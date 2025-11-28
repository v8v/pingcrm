<template>

    <Head title="计算器" />
    <div class="container" id="container">

        <div class="page form_page js_show">
            <div class="weui-form">

                <form @submit.prevent="store">

                    <div class="weui-form__bd">
                        <div class="weui-form__text-area">
                            <h2 class="weui-form__title">排列五-四字定</h2>
                            <!-- <div class="weui-form__desc">这是一个排列五计算器，可以根据以往数据进行规律演算。</div> -->
                        </div>

                        <div class="weui-form__control-area">
                            <div class="weui-cells__group weui-cells__group_form">
                                <div class="weui-cells__title">不定位合分</div>


                                <div class="weui-cells">


                                    <!--  两数合 三数合 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">

                                            <label for="lsh" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">两数合</span></div>
                                                <div class="weui-cell__bd">
                                                    <input v-model="form.lsh" id="lsh" name="lsh" class="weui-input">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">

                                            <label for="js_input2" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">三数合</span></div>
                                                <div class="weui-cell__bd">
                                                    <input id="js_input2" v-model="form.ssh" class="weui-input">
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                     <!-- 全转，排除 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">全转</span></div>
                                                <div class="weui-cell__bd">
                                                    <input id="js_input1" v-model="form.qz" class="weui-input">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">排除</span></div>
                                                <div class="weui-cell__bd">
                                                    <input id="js_input1" v-model="form.pc" class="weui-input">
                                                </div>
                                            </label>
                                        </div>

                                    </div>

                                     <!-- 上奖 取值范围 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">上奖</span></div>
                                                <div class="weui-cell__bd">
                                                    <input id="js_input1" v-model="form.sj" class="weui-input">
                                                </div>
                                            </label>
                                        </div>

                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">取值范围</span></div>
                                                <div class="weui-cell__bd">
                                                    <!-- <picker :data='years001' v-model='year001' @on-change='change'></picker> -->
                                                    <input id="qzfw" @click="showCascadePicker" type="text"
                                                        v-model="form.qzfw" class="weui-input">
                                                    <span v-if="form.qzfw" class="clear-btn" @click="clearQzfw">×</span>
                                                </div>

                                            </label>
                                        </div>

                                    </div>

                                </div>



                                 <!-- 双重 双双重 三重 四重 -->
                                <div class="weui-cells">
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">双重</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.shuangchong" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>

                                                    </div>
                                                </div>

                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">双双重</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.shuangshuangchong" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">三重</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.sanchong" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">四重</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.sichong" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                </div>


                                 <!-- 二兄弟 三兄弟 四兄弟 -->
                                <div class="weui-cells">
                                    
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">二兄弟</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.erxiongdi" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">三兄弟</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.sanxiongdi" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">四兄弟</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.sixiongdi" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                    </div>

                                </div>



                                <div class="weui-cells">
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label">对数</span></div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.duishu" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__bd">
                                                        <Checker v-model="form.duishuValue" type="checkbox"
                                                            default-item-class="demo8-item"
                                                            selected-item-class="demo1-item-selected">
                                                           
                                                            <CheckerItem value="16">16</CheckerItem>
                                                            <CheckerItem value="27">27</CheckerItem>
                                                            <CheckerItem value="38">38</CheckerItem>
                                                            <CheckerItem value="49">49</CheckerItem>
                                                            <CheckerItem value="50">50</CheckerItem>
                                                            
                                                        </Checker>
                                             


                                                </div>
                                            </label>
                                        </div>

                                    </div>



                                </div>
                                <div class="weui-cells">
                                        <!-- 单 -->                                       
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label center">单</span>
                                                </div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.dans" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">

                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.dan" type="checkbox"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">千</CheckerItem>
                                                            <CheckerItem value="2">百</CheckerItem>
                                                            <CheckerItem value="3">十</CheckerItem>
                                                            <CheckerItem value="4">个</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- 双 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label center">双</span>
                                                </div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.shuangs" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">

                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.shuang" type="checkbox"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">千</CheckerItem>
                                                            <CheckerItem value="2">百</CheckerItem>
                                                            <CheckerItem value="3">十</CheckerItem>
                                                            <CheckerItem value="4">个</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- 大 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label center">大</span>
                                                </div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.das" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">

                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.da" type="checkbox"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">千</CheckerItem>
                                                            <CheckerItem value="2">百</CheckerItem>
                                                            <CheckerItem value="3">十</CheckerItem>
                                                            <CheckerItem value="4">个</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- 小 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label center">小</span>
                                                </div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.xiaos" type="radio"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">除</CheckerItem>
                                                            <CheckerItem value="2">取</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">

                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <Checker v-model="form.xiao" type="checkbox"
                                                            default-item-class="demo1-item"
                                                            selected-item-class="demo1-item-selected">
                                                            <CheckerItem value="1">千</CheckerItem>
                                                            <CheckerItem value="2">百</CheckerItem>
                                                            <CheckerItem value="3">十</CheckerItem>
                                                            <CheckerItem value="4">个</CheckerItem>
                                                        </Checker>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- 查询期数 -->
                                    <div class="weui-flex">
                                        <div class="weui-flex__item">
                                            <label for="js_input1" class="weui-cell weui-cell_active">
                                                <div class="weui-cell__hd"><span class="weui-label center">查询期数</span>
                                                </div>
                                                <div class="weui-cell__bd">
                                                    <div class="box">
                                                        <input id="cxqs" v-model="form.cxqs" class="weui-input">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="weui-flex__item">

                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>




                    </div>



                    <div class="weui-form__ft">

                        <div class="weui-form__opr-area">
                            <button type="submit" role="button" aria-disabled="true" class="weui-btn weui-btn_primary "
                                id="showTooltips" wah-hotarea="click">确定</button>
                        </div>


                        <!-- <div class="weui-form__extra-area">
                            <div class="weui-footer">
                                <p class="weui-footer__links">
                                    <a href="javascript:" class="weui-footer__link">底部链接文本</a>
                                </p>
                                <p class="weui-footer__text">Copyright © 2008-2019 weui.io</p>
                            </div>
                        </div> -->
                    </div>
                </form>
            </div>

        </div>



    </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
// import checker from '../../Shared/Checker.vue';
// import checkerItem from '../../Shared/Checker-item.vue';
// import { Checker, CheckerItem, Divider, Group, Cell, Popup, TransferDom } from 'vux'
import { Checker, CheckerItem } from '../../Comm/Checker';
// import {Checker,CheckerItem} from 'vux/src/components/checker';
// import { Divider } from '/vux/src/components/divider/divider.vue';
// import { Group } from 'vux/src/components/group/group.vue';
// import { Cell } from 'vux/src/components/cell/cell.vue';
// import { Popup } from 'vux/src/components/popup/popup.vue';
// import checker from 'vux/src/components/checker/checker.vue';
// import checkerItem from 'vux/src/components/checker/checker-item.vue';
// import { Picker } from 'vux';
// import vux from 'vux';
import weui from 'weui.js';


export default {
    components: {
        Head,
        Checker,
        CheckerItem,
        // Picker
        // Divider,
        // Group,
        // Cell,
        // Popup
    },

    methods: {
        onItemClick(value, disabled) {
            console.log(value, disabled)
            if (!this.disabled) {
                this.showPopup = false
            }
        },
        store() {
            this.form.post('/search')
        },
        showCascadePicker() {
            const self = this;

            const pickerData = [
                { label: '0', value: '0' }, { label: '1', value: '1' }, { label: '2', value: '2' },
                { label: '3', value: '3' }, { label: '4', value: '4' }, { label: '5', value: '5' },
                { label: '6', value: '6' }, { label: '7', value: '7' }, { label: '8', value: '8' },
                { label: '9', value: '9' }, { label: '10', value: '10' }, { label: '11', value: '11' },
                { label: '12', value: '12' }, { label: '13', value: '13' }, { label: '14', value: '14' },
                { label: '15', value: '15' }, { label: '16', value: '16' }, { label: '17', value: '17' },
                { label: '18', value: '18' }, { label: '19', value: '19' }, { label: '20', value: '20' },
                { label: '21', value: '21' }, { label: '22', value: '22' }, { label: '23', value: '23' },
                { label: '24', value: '24' }, { label: '25', value: '25' }, { label: '26', value: '26' },
                { label: '27', value: '27' }, { label: '28', value: '28' }, { label: '29', value: '29' },
                { label: '30', value: '30' }, { label: '31', value: '31' }, { label: '32', value: '32' },
                { label: '33', value: '33' }, { label: '34', value: '34' }, { label: '35', value: '35' },
                { label: '36', value: '36' }
            ];
            weui.picker(
                [
                    { label: '0', value: '0' },
                    { label: '1', value: '1' },
                    { label: '2', value: '2' },
                    { label: '3', value: '3' },
                    { label: '4', value: '4' },
                    { label: '5', value: '5' },
                    { label: '6', value: '6' },
                    { label: '7', value: '7' },
                    { label: '8', value: '8' },
                    { label: '9', value: '9' },
                    { label: '10', value: '10' },
                    { label: '11', value: '11' },
                    { label: '12', value: '12' },
                    { label: '13', value: '13' },
                    { label: '14', value: '14' },
                    { label: '15', value: '15' },
                    { label: '16', value: '16' },
                    { label: '17', value: '17' },
                    { label: '18', value: '18' },
                    { label: '19', value: '19' },
                    { label: '20', value: '20' },
                    { label: '21', value: '21' },
                    { label: '22', value: '22' },
                    { label: '23', value: '23' },
                    { label: '24', value: '24' },
                    { label: '25', value: '25' },
                    { label: '26', value: '26' },
                    { label: '27', value: '27' },
                    { label: '28', value: '28' },
                    { label: '29', value: '29' },
                    { label: '30', value: '30' },
                    { label: '31', value: '31' },
                    { label: '32', value: '32' },
                    { label: '33', value: '33' },
                    { label: '34', value: '34' },
                    { label: '35', value: '35' },
                    { label: '36', value: '36' },

                ], [
                { label: '0', value: '0' },
                { label: '1', value: '1' },
                { label: '2', value: '2' },
                { label: '3', value: '3' },
                { label: '4', value: '4' },
                { label: '5', value: '5' },
                { label: '6', value: '6' },
                { label: '7', value: '7' },
                { label: '8', value: '8' },
                { label: '9', value: '9' },
                { label: '10', value: '10' },
                { label: '11', value: '11' },
                { label: '12', value: '12' },
                { label: '13', value: '13' },
                { label: '14', value: '14' },
                { label: '15', value: '15' },
                { label: '16', value: '16' },
                { label: '17', value: '17' },
                { label: '18', value: '18' },
                { label: '19', value: '19' },
                { label: '20', value: '20' },
                { label: '21', value: '21' },
                { label: '22', value: '22' },
                { label: '23', value: '23' },
                { label: '24', value: '24' },
                { label: '25', value: '25' },
                { label: '26', value: '26' },
                { label: '27', value: '27' },
                { label: '28', value: '28' },
                { label: '29', value: '29' },
                { label: '30', value: '30' },
                { label: '31', value: '31' },
                { label: '32', value: '32' },
                { label: '33', value: '33' },
                { label: '34', value: '34' },
                { label: '35', value: '35' },
                { label: '36', value: '36' },
            ], {
                onChange: function (result) {
                    //   console.log(result);
                },
                onConfirm: function (result, form) {
                    if (result && result.length >= 2) {
                        self.form.qzfw = result[0].label + '-' + result[1].label;
                        console.log('选择的值:', self.form.qzfw);
                    }
                },
                onClose: function (result) {

                },
                title: '取值范围',
                defaultValue: [7, 25],
                showClose: true,
                id: 'cascadePicker'
            });
        },
        // 清除取值范围
        clearQzfw() {
            this.form.qzfw = '';
        },

    },
    data() {
        return {

            form: this.$inertia.form({
                lsh: '',
                ssh: '14579',    // 三数合
                qz: '',
                pc: '',
                sj: '13457',         // 上奖
                qzfw: '',
                shuangchong: 0,   //双重
                shuangshuangchong: 0,  //双双重
                sanchong: 0,  //三重
                sichong: 0,  //四重
                erxiongdi: 0,  // 二兄弟
                sanxiongdi: 0, // 三兄弟
                sixiongdi: 0,  // 四兄弟
                dan: [],
                dans: '',
                shuangs: [],
                shuang: '',
                das: [],
                da: '',
                xiaos: [],
                xiao: '',
                duishu: '',         // 对数
                duishuValue: '',    // 对数值
                cxqs: 100,
            })
        }
    }

}
</script>

<style scoped>
html {
    background-color: #191919;
}
.weui-form__opr-area {
     margin-bottom: 50px;
}
.weui-btn {
    border-radius: 0;
    line-height: 0.5;
    background-color: #07c160;
    color: black;
}

.center {
    text-align: center;
}

.weui-form__title {
    color: #07c160;
    font-weight: bold;
}

.weui-cell {
    font-size: 14px;
    color: #07c160;
    padding: 10px 5px;
}

.weui-cells__group_form .weui-label {
    max-width: 4em;
}

.weui-input {
    border-bottom: 1px solid #07c160;
    text-align: center;

}

.box {
    padding: 0;
}

.demo1-item {
    border: 1px solid #07c160;
    padding: 5px 10px;
}

.demo8-item {
    border: 1px solid #07c160;
    padding: 5px 7px;
}


.demo1-item-selected {
    border: 1px solid #07c160;
    color: rgb(0, 0, 0);
    background-color: #07c160;
}

.demo2-item {
    width: 40px;
    height: 40px;
    border: 1px solid #ccc;
    display: inline-block;
    border-radius: 50%;
    line-height: 40px;
    text-align: center;
}

.demo2-item-selected {
    border-color: green;
}

.demo3-item {
    padding: 5px 5px;
    font-size: 0;
}

.demo3-item-selected {
    outline: 1px solid #8B8AEE;
}

.demo4-item {
    background-color: #ddd;
    color: #222;
    font-size: 14px;
    padding: 5px 10px;
    margin-right: 10px;
    line-height: 18px;
    border-radius: 15px;
}

.demo4-item-selected {
    background-color: #FF3B3B;
    color: #fff;
}

.demo4-item-disabled {
    color: #999;
}

.demo5-item {
    width: 100px;
    height: 26px;
    line-height: 26px;
    text-align: center;
    border-radius: 3px;
    border: 1px solid #ccc;
    background-color: #fff;
    margin-right: 6px;
}

.demo5-item-selected {
    background: #ffffff url(../assets/demo/checker/active.png) no-repeat right bottom;
    border-color: #ff4a00;
}

/* 新增清除按钮样式 */
.weui-cell__bd_with-clear {
    position: relative;
}

.clear-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    line-height: 18px;
    text-align: center;
    /* background: #ccc; */
    /* border-radius: 50%; */
    color: #07c160;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10;
}

.clear-btn:hover {
    background: #999;
}

/* 确保输入框有足够的右边距给清除按钮 */
.weui-cell__bd_with-clear .weui-input {
    padding-right: 30px;
}

/* 清除选项的特殊样式 */
:deep(.weui-picker__item[data-value="clear"]) {
    color: #ff4444 !important;
    font-weight: bold;
}
</style>