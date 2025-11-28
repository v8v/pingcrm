<template>
  <div class="vux-checker-item" :class="classNames" @click="select">
    <slot></slot>
  </div>
</template>

<script>
import { defineComponent, computed, inject, watch, toRef } from 'vue'

export default defineComponent({
  name: 'CheckerItem',
  props: {
    value: {
      type: [String, Number, Object],
      required: true
    },
    disabled: Boolean
  },
  emits: ['on-item-click'],
  setup(props, { emit }) {
    const parent = inject('checkerContext')

    if (!parent) {
      throw new Error('CheckerItem must be used within Checker component')
    }

    const isSimpleValue = computed(() => {
      return typeof props.value === 'string' || typeof props.value === 'number'
    })

    const classNames = computed(() => {
      const names = {
        'vux-tap-active': !props.disabled
      }

      if (parent.defaultItemClass) {
        names[parent.defaultItemClass.value] = true
      }

      if (parent.selectedItemClass) {
        let selected = false
        if (parent.type.value === 'radio') {
          if (isSimpleValue.value && parent.currentValue.value === props.value) {
            selected = true
          } else if (typeof props.value === 'object' && isEqual(parent.currentValue.value, props.value)) {
            selected = true
          }
        } else {
          if (typeof props.value === 'string') {
            if (parent.currentValue.value && parent.currentValue.value.indexOf(props.value) > -1) {
              selected = true
            }
          } else if (parent.currentValue.value && parent.currentValue.value.length) {
            const match = parent.currentValue.value.filter(one => {
              return isEqual(one, props.value)
            })
            selected = match.length > 0
          }
        }
        names[parent.selectedItemClass.value] = selected
      }

      if (parent.disabledItemClass) {
        names[parent.disabledItemClass.value] = props.disabled
      }

      return names
    })

    watch(() => props.disabled, (val) => {
      if (val && parent.type.value === 'radio' && props.value === parent.currentValue.value) {
        parent.currentValue.value = ''
      }
    })

    const selectRadio = () => {
      if (!props.disabled) {
        if (parent.currentValue.value === props.value) {
          if (!parent.radioRequired.value) {
            parent.currentValue.value = ''
          }
        } else {
          parent.currentValue.value = props.value
        }
      }
      emit('on-item-click', props.value, props.disabled)
    }

    const selectCheckbox = () => {
      if (!parent.currentValue.value || parent.currentValue.value === null) {
        parent.currentValue.value = []
      }
      
      if (!props.disabled) {
        let index = -1
        if (isSimpleValue.value) {
          index = parent.currentValue.value.indexOf(props.value)
        } else {
          index = parent.currentValue.value.map(one => JSON.stringify(one)).indexOf(JSON.stringify(props.value))
        }
        if (index > -1) {
          parent.currentValue.value.splice(index, 1)
        } else {
          if (!parent.max.value || (parent.max.value && (parent.currentValue.value !== null && parent.currentValue.value.length < parent.max.value))) {
            if (!parent.currentValue.value || !parent.currentValue.value.length) {
              parent.currentValue.value = []
            }
            parent.currentValue.value.push(props.value)
          }
        }
      }
      emit('on-item-click', props.value, props.disabled)
    }

    const select = () => {
      if (parent.type.value === 'radio') {
        selectRadio()
      } else {
        selectCheckbox()
      }
    }

    const isEqual = (obj1, obj2) => {
      return JSON.stringify(obj1) === JSON.stringify(obj2)
    }

    return {
      classNames,
      select
    }
  }
})
</script>

<style lang="less">
@import '../../../css/tap.less';
</style>