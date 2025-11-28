<template>
  <div class="vux-checker-box">
    <slot></slot>
  </div>
</template>

<script>
import { defineComponent, ref, watch, provide, toRef } from 'vue'

export default defineComponent({
  name: 'Checker',
  props: {
    defaultItemClass: String,
    selectedItemClass: String,
    disabledItemClass: String,
    type: {
      type: String,
      default: 'radio'
    },
    modelValue: {
      type: [String, Number, Array, Object],
      default: null
    },
    max: Number,
    radioRequired: Boolean
  },
  emits: ['update:modelValue', 'on-change'],
  setup(props, { emit }) {
    const currentValue = ref(props.modelValue)

    watch(() => props.modelValue, (newValue) => {
      currentValue.value = newValue
    })

    watch(currentValue, (val) => {
      emit('update:modelValue', val)
      emit('on-change', val)
    })

    // 提供上下文给子组件
    provide('checkerContext', {
      defaultItemClass: toRef(props, 'defaultItemClass'),
      selectedItemClass: toRef(props, 'selectedItemClass'),
      disabledItemClass: toRef(props, 'disabledItemClass'),
      type: toRef(props, 'type'),
      currentValue,
      max: toRef(props, 'max'),
      radioRequired: toRef(props, 'radioRequired')
    })

    return {
      currentValue
    }
  }
})
</script>

<style>
.vux-checker-item {
  display: inline-block;
}
</style>