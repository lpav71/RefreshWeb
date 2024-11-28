<template>
    <div class="main">
        <div class="top">
            <i class="fas fa-sort-amount-up" style="margin-right: 10px;"></i><span>Статистика</span>
            <button class="btn btn-success" style="margin-left: 10px;">Портал статистики</button>
        </div>
        <div class="bottom">
            <div class="left_part">
                <div class="left_top">
                    <div class="dash_1">
                        <div class="dash_1_top">
                            <div class="dash_1_top_left">
                                <span>Ваши результаты</span>
                            </div>
                            <div class="dash_1_top_right">
                                <button class="btn btn-success" style="margin-left: 10px;">Выбрать период</button>
                            </div>
                        </div>
                        <div class="dash_1_bottom">
                            <div class="summy">
                                <span class="s1">Общая выручка</span>
                                <span class="s2">{{ ravenue.TotalRevenue }}</span>
                            </div>
                            <div class="summy">
                                <span class="s1">Доход с ПК</span>
                                <span class="s2">{{ ravenue.IncomeFromPC }}</span>
                            </div>
                            <div class="summy">
                                <span class="s1">Доход с товаров</span>
                                <span class="s2">{{ ravenue.IncomeFromGoods }}</span>
                            </div>
                            <div class="summy" style="border: none">
                                <span class="s1">Доход с консолей</span>
                                <span class="s2">{{ ravenue.RevenueFromConsoles }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left_bottom">
                    <div class="dash_2">
                        <div class="dash_2_top_bottom">
                            <div class="popularity">
                                <div class="pop1">
                                    <div class="pop2">
                                        <span>Популярность игр и приложений</span>
                                        <button class="btn btn-success" style="margin-left: 10px;width: 170px">Выбрать период</button>
                                    </div>
                                    <div class="pop3">
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="popularity">
                                <div class="pop1">
                                    <div class="pop2">
                                        <span>Популярность тарифов</span>
                                        <button class="btn btn-success" style="margin-left: 10px;width: 170px">Выбрать период</button>
                                    </div>
                                    <div class="pop3">
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="popularity">
                                <div class="pop1">
                                    <div class="pop2">
                                        <span>Популярность товаров</span>
                                        <button class="btn btn-success" style="margin-left: 10px;width: 170px">Выбрать период</button>
                                    </div>
                                    <div class="pop3">
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                        <div class="pop4"><span>Dota</span><span>235745 запусков</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dash_2_top_bottom">
                            <div class="popularity">
                                <div class="pop1">
                                    <div class="pop2">
                                        <span>Популярность товаров</span>
                                        <button class="btn btn-success" style="margin-left: 10px;">Выбрать период</button>
                                    </div>
                                    <div class="chart_1">
                                        <GChart :data="chartData" :options="chartOptions" :settings="{packages: ['corechart']}" type="PieChart"/>
                                    </div>
                                </div>
                            </div>
                            <div class="popularity">
                                <div class="pop1">
                                    <div class="pop2">
                                        <span>Популярность товаров</span>
                                        <button class="btn btn-success" style="margin-left: 10px;">Выбрать период</button>
                                    </div>
                                    <div class="chart_1">
                                        <GChart :data="chartData" :options="chartOptions" :settings="{packages: ['corechart']}" type="PieChart"/>
                                    </div>
                                </div>
                            </div>
                            <div class="popularity">
                                <div class="pop1">
                                    <div class="pop2">
                                        <span>Популярность товаров</span>
                                        <button class="btn btn-success" style="margin-left: 10px;">Выбрать период</button>
                                    </div>
                                    <div class="chart_1">
                                        <GChart :data="chartData" :options="chartOptions" :settings="{packages: ['corechart']}" type="PieChart"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right_part">
                <div class="dash_3">
                    <div class="right_adm">
                        <span class="s1">Средняя выручка администратора</span>
                        <span class="s2">{{ ravenue.AverageRevenueAdministrator }}</span>
                    </div>
                    <div class="avg_income">
                        <span class="s1">Ориентированность на доход (Ср/выр)</span>
                        <hr/>
                        <div class="income_adm">
                            <span class="income_adm_name">Александр Святой</span>
                            <div class="income_all">
                                <div class="income_data">
                                    <span>90</span>
                                </div>
                            </div>
                        </div>
                        <div class="income_adm">
                            <span class="income_adm_name">Александр Святой</span>
                            <div class="income_all">
                                <div class="income_data">
                                    <span>90</span>
                                </div>
                            </div>
                        </div>
                        <div class="income_adm">
                            <span class="income_adm_name">Александр Святой</span>
                            <div class="income_all">
                                <div class="income_data">
                                    <span>90</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="avg_income">
                        <span class="s1">Средняя загрузка клуба</span>
                        <hr/>
                        <div class="income_adm">
                            <span class="income_adm_name">00:00-08:00</span>
                            <div class="income_all">
                                <div :style="{width: workloadWidth[0] + 'px'}" class="income_data2">
                                    <span>{{ workload[0] }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="income_adm">
                            <span class="income_adm_name">08:00-12:00</span>
                            <div class="income_all">
                                <div :style="{width: workloadWidth[1] + 'px'}" class="income_data2">
                                    <span>{{ workload[1] }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="income_adm">
                            <span class="income_adm_name">12:00-18:00</span>
                            <div class="income_all">
                                <div :style="{width: workloadWidth[2] + 'px'}" class="income_data2">
                                    <span>{{ workload[2] }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="income_adm">
                            <span class="income_adm_name">18:00-00:00</span>
                            <div class="income_all">
                                <div :style="{width: workloadWidth[3] + 'px'}" class="income_data2">
                                    <span>{{ workload[3] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>
</template>

<script>
import {GChart} from "vue-google-charts";

export default {
    name      : "Dashboard",
    components: {
        GChart
    },
    props     : ['club_id', 'user_id'],
    data() {
        return {
            ravenue      : [],
            workload     : [],
            workloadWidth: [],
            chartData    : [
                ['Task', 'Hours per Day'],
                ['Работа', 11],
                ['Еда', 2],
                ['Общение', 2],
                ['Watch TV', 2],
                ['Сон', 7]
            ],
            chartOptions : {
                pieHole        : 0.4,
                backgroundColor: '#122733',
                color          : '#ffffff',
                chart          : {
                    title: 'Company Performance'
                },
                legend         : {
                    position : 'left',
                    maxLines : 3,
                    textStyle: {
                        color: '#ffffff',
                    }
                },
            }
        }
    },
    methods: {
        async getBookingPercent() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/get-hours", requestOptions);
            if (response.ok) {
                this.workload   = await response.json();
                var widthIncome = document.querySelector('.income_all').offsetWidth;
                this.workload.forEach(function (item, index) {
                    var w = this.workload[index] * widthIncome / 100;
                    this.workloadWidth.push(w);
                }.bind(this))
            }
        },
        async getRavenue() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("admin", this.$props.user_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/statistic", requestOptions);
            if (response.ok) {
                this.ravenue = await response.json(); //Доход
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        this.getBookingPercent();
        this.getRavenue();
    }
}
</script>

<style scoped>
.bt {
    background    : var(--light-green);
    border-radius : 5px 25px 5px 25px;
    font-size     : inherit;
}

.main {
    width       : 1794px;
    height      : 960px;
    margin-left : 12px;
    color       : var(--standart-gray);
}

.top {
    height      : 60px;
    padding-top : 14px;
}

.bottom {
    height  : 900px;
    display : flex;
}

.left_part {
    width  : 1450px;
    height : 100%;
}

.right_part {
    width  : 344px;
    height : 100%;
}

.left_top {
    width      : 100%;
    height     : 200px;
    margin-top : 20px;
}

.left_bottom {
    width  : 100%;
    height : 680px;
}

.dash_1 {
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
    width         : 1440px;
    height        : 180px;
}

.dash_2 {
    background      : var(--light-blue-bg-color);
    border-radius   : 20px;
    width           : 1440px;
    height          : 680px;
    display         : flex;
    flex-direction  : column;
    justify-content : space-evenly;
    align-items     : center;
}

.dash_3 {
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
    width         : 330px;
    height        : 880px;
    margin-left   : 10px;
    margin-top    : 20px;
}

.dash_1_top {
    height          : 50px;
    display         : flex;
    justify-content : space-between;
    width           : 1380px;
    margin          : 0 auto;
    align-items     : center;
    position        : relative;
    top             : 10px;
}

.dash_1_bottom {
    height  : 110px;
    width   : 1400px;
    margin  : 10px auto;
    display : flex;
}

.summy {
    border-right    : 1px solid #62a7aa;
    width           : 350px;
    height          : 110px;
    display         : flex;
    flex-direction  : column;
    justify-content : space-between;
    padding         : 0 10px 30px 10px;
}

.s2 {
    color       : var(--light-green);
    font-size   : 73px;
    margin-left : 33px;
}

.s1 .s2 {
    margin-left : 33px;
}

.dash_2_top_bottom {
    width           : 1400px;
    height          : 300px;
    display         : flex;
    justify-content : space-between;
}

.popularity {
    background      : #122733;
    width           : 452px;
    height          : 300px;
    border-radius   : 20px;
    display         : flex;
    justify-content : center;
    align-items     : center;
}

.pop1 {
    width  : 412px;
    height : 260px;
}

.pop2 {
    display         : flex;
    justify-content : space-between;
    border-bottom   : 1px solid #353535;
    align-items     : center;
    padding-bottom  : 13px;
}

.pop3 {
    display        : flex;
    flex-direction : column;
}

.pop4 {
    display         : flex;
    justify-content : space-between;
    margin-top      : 14px;
}

.right_adm {
    display         : flex;
    flex-direction  : column;
    height          : 140px;
    justify-content : space-between;
    text-align      : center;
    position        : relative;
    padding         : 10px 0 45px 0;
    border-bottom   : 1px solid #353535;
}

.right_adm .s2 {
    margin-left : 0;
}

.avg_income {
    text-align : center;
    margin-top : 13px;
}

.income_adm {
    display         : flex;
    flex-direction  : column;
    align-items     : flex-start;
    height          : 84px;
    justify-content : space-between;
    padding         : 10px 0 10px 14px;
}

.income_adm_name {

}

.income_all, .income_data, .income_data2 {
    height              : 32px;
    border-radius       : 6px;
    transition-duration : 300ms;
}

.income_all {
    width      : 300px;
    background : var(--standart-black);
}

.income_data {
    width       : 170px;
    background  : var(--dark-green);
    display     : flex;
    align-items : center;
}

.income_data:hover {
    background : var(--light-green);
}

.income_data2:hover {
    background : #c6c6c6;
    color      : black;
}

.income_data2 {
    width       : 170px;
    background  : rgba(198, 198, 198, 0.5);
    display     : flex;
    align-items : center;
}

.income_data span, .income_data2 span {
    margin-left : 20px;
}
</style>
