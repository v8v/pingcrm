<template>
    <Head title="计算结果" />
    <div class="container" id="container">
        <div class="page form_page js_show">
            <div class="weui-form">
                <div class="weui-form__bd">
                    <div class="weui-form__text-area">
                        <h2 class="weui-form__title">计算结果</h2>
                        <div class="weui-form__desc">共查询：{{ num }} 期，中奖{{ searchSums }}期，胜率：{{ winRate }}%</div>
                        <div class="weui-form__desc">{{ caleTitles }}</div>
                    </div>

                    <div class="weui-form__control-area">
                        <div class="weui-cells__title">连续不中奖统计：</div>
                        <div class="weui-cells">
                            <div class="weui-cell__hd">
                                <div class="table-container">
                                    <table v-if="Object.keys(noZhongNums).length">
                                        <thead>
                                            <tr>
                                                <th>期数</th>
                                                <th>次数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(value, key) in noZhongNums" :key="key">
                                                <td>{{ key }}</td>
                                                <td>{{ value }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-else class="empty-state">暂无数据</div>
                                </div>
                            </div>
                        </div>

                        <div class="weui-cells__title">连续中奖统计：</div>
                        <div class="weui-cells">
                            <div class="weui-cell__hd">
                                <div class="table-container">
                                    <table v-if="Object.keys(zhongNums).length">
                                        <thead>
                                            <tr>
                                                <th>期数</th>
                                                <th>次数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(value, key) in zhongNums" :key="key">
                                                <td>{{ key }}</td>
                                                <td>{{ value }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-else class="empty-state">暂无数据</div>
                                </div>
                            </div>
                        </div>

                        <div class="weui-cells__title">选择条件不符统计：</div>
                        <div class="weui-cells">
                            <div class="weui-cell__hd">
                                <div class="table-container">
                                    <table v-if="Object.keys(typeSums).length">  <!-- 修复：使用正确的属性名 -->
                                        <thead>
                                            <tr>
                                                <th>条件不符</th>
                                                <th>次数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(value, key) in typeSums" :key="key">  <!-- 修复：使用正确的属性名 -->
                                                <td>{{ value[1] }}</td>
                                                <td>{{ value[0] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-else class="empty-state">暂无数据</div>
                                </div>
                            </div>
                        </div>


                          <div class="weui-cells__title">详细清单</div>
                        <div class="weui-cells">
                            <div class="weui-cell__hd">
                                <div class="table-container detail" style="padding: 0;">
                                    <table v-if="Object.keys(typeSums).length">  <!-- 修复：使用正确的属性名 -->
                                        <thead>
                                            <tr>
                                                <th>期数</th>
                                                <th>千</th>
                                                <th>百</th>
                                                <th>十</th>
                                                <th>个</th>
                                                <th>提示信息</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(value, key) in recordLists" :key="key">  <!-- 修复：使用正确的属性名 -->
                                                <td>{{ value.number }}</td>
                                                <td>{{ value.r1 }}</td>
                                                <td>{{ value.r2 }}</td>
                                                <td>{{ value.r3 }}</td>
                                                <td>{{ value.r4 }}</td>
                                                <td><div v-if="value.message" style="color:aliceblue" v-html="formatMessage(value.message)"></div>
                                                    <span v-else>中奖</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-else class="empty-state">暂无数据</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="weui-form__ft">
                    <div class="weui-form__opr-area">
                        <Link href="/lottery" class="weui-btn" id="showTooltips" wah-hotarea="click">返回</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';

export default {
    components: { Head, Link },
    props: {
        contact: String,
        noZhongNum: { type: Object, default: () => ({}) },
        zhongNum: { type: Object, default: () => ({}) },
        number: { type: Number, default: 0 },
        searchSum: { type: Number, default: 0 },
        caleTitle: { type: String, default: '' },
        typeSum: { type: Object, default: () => ({}) },
        recordList: { type: Array, default: () => ([]) },
    },
    computed: {
        noZhongNums() {
            return this.noZhongNum?.[1] || {};
        },
        zhongNums() {
            return this.zhongNum?.[0] || {};
        },
        num() {
            return this.number || 0;
        },
        searchSums() {
            return this.searchSum || 0;
        },
        caleTitles() {
            return this.caleTitle || '';
        },
        typeSums() {  // 修复：避免与props同名
            return this.typeSum || {};
        },
        recordLists() {  // 修复：避免与props同名
            return this.recordList || [];
        },
        winRate() {
            if (!this.num) return '0.00';
            return ((this.searchSums / this.num) * 100).toFixed(2);
        }
    },
    methods: {
        formatMessage(message) {
            return message.replace(/；/g, '<br />');
        }
    }
}
</script>

<style>
html {
    background-color: #191919;
}
.detail th, .detail td {
    padding: 8px 0px;
    border: 1px solid #07c160;
}

.container {}

.empty-state {
    text-align: center;
    padding: 20px;
    color: #999;
}

.table-container {
    overflow-x: auto;
    text-align: center;
    color: #07c160;
    padding: 0 50px;

}
.weui-form__title {
    color: #07c160;
    font-weight: bold;
}
.weui-form__desc{
    color: #07c160;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th {
    /* background-color: #07c160; */
    font-weight: 500;
    padding: 10px 15px;
    border-bottom: 3px solid #07c160;
    color: #07c160;
}

td {
    padding: 10px 15px;
    border-bottom: 1px solid #07c160;
}

tr:hover {
    background-color: #07c160;
    color: #000;
}

.weui-btn {
    border-radius: 0;
    line-height: 0.5;
    background-color: #07c160;
    color: black;
}
</style>