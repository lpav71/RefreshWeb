<template>
    <div class="home">
        <div class="header">
            <div class="left">
                <div class="top"><img alt="" src="img/4.svg"/><span style="margin-left: 14px;">Тарифы и предложения</span>
                </div>
            </div>
            <div class="right">
                <button class="btn btn-success" type="button" @click="addModalShow">Добавить</button>
            </div>
        </div>
        <div class="bottom">
            <div class="in-bottom">

                <div class="tariff-name">
                    <span style="margin-right: 10px">Поминутный</span>
                    <i class="far fa-clock icon"></i>
                    <select class="div_4">
                        <option disabled selected value="">Выберите тариф</option>
                        <option v-for="t in 3">Value</option>
                    </select>
                </div>
                <div class="t0">
                    <div v-for="(g, index) in tariffs0" class="goods">
                        <div class="goods_img"><img alt="" height="200" src="images/tariff.png"></div>
                        <div class="goods_text">
                            <div class="time-data">{{ g.time_start }} {{ g.time_stop }}</div>
                            <div class="time-data">&emsp;{{ g.price }}р/мин</div>
                        </div>
                        <div class="goods-btn">
                            <span style="font-size: 15px">{{ g.name }}&emsp;</span>
                            <button class="goods_cart" type="button" @click="editModal(index)"><i class="fa fa-edit fa-lg"></i></button>
                        </div>
                    </div>
                </div>

                <div class="tariff-name">
                    <span style="margin-right: 10px">Пакетное предложение</span>
                    <i class="far fa-clock icon"></i>
                    <select class="div_4">
                        <option disabled selected value="">Выберите тариф</option>
                        <option v-for="t in 3">Value</option>
                    </select>
                </div>
                <div class="t0">
                    <div v-for="(g, index) in tariffs1" class="goods">
                        <div class="goods_img"><img alt="" height="200" src="images/tariff.png"></div>
                        <div class="goods_text">
                            <div class="time-data">{{ g.time_start }} {{ g.time_stop }}</div>
                            <div class="time-data">&emsp;{{ g.price }}р/мин</div>
                        </div>
                        <div class="goods-btn">
                            <span style="font-size: 15px">{{ g.name }}&emsp;</span>
                            <button class="goods_cart" type="button" @click="editModal(index)"><i class="fa fa-edit fa-lg"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="addTariffModal" aria-hidden="true" aria-labelledby="addTariffModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addTariffModalLabel" class="modal-title">Новый тариф</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="block" style="margin-top: 0">
                        <span>Тариф</span>
                        <input v-model="name" class="input w1" placeholder="Введите наименование" type="text"/>
                    </div>
                    <div class="bottom2">
                        <div class="left-right">
                            <div class="block" style="margin-top: 0">
                                <span>День недели</span>
                                <select v-model="week_day" class="input w2">
                                    <option value="1">Понедельник</option>
                                    <option value="2">Вторник</option>
                                    <option value="3">Среда</option>
                                    <option value="4">Четверг</option>
                                    <option value="5">Пятница</option>
                                    <option value="6">Суббота</option>
                                    <option value="7">Воскресенье</option>
                                </select>
                            </div>
                            <div class="block" style="margin-top: 0">
                                <span>Время жизни</span>
                                <input v-model="booking_alive" class="input w2" type="text"/>
                            </div>
                        </div>
                        <div class="left-right">
                            <div class="block" style="margin-top: 0">
                                <span>Зона</span>
                                <select v-model="id_zone" class="input w2">
                                    <option v-for="z in zone" :value="z.num">{{ z.name }}</option>
                                </select>
                            </div>
                            <button class="btn btn-success me-2 mt-4" @click="encriment"> +</button>
                            <button class="btn btn-success mt-4" @click="decriment"> -</button>
                        </div>
                    </div>
                    <template v-for="(a, index) in additionalBlock">
                        <div class="bottom2">
                            <div class="left-right">
                                <div class="block" style="margin-top: 0">
                                    <span>Начало</span>
                                    <input v-model="a.time_start" class="input w2" type="text"/>
                                </div>
                                <div class="block" style="margin-top: 0">
                                    <span>Продолжительность</span>
                                    <input v-model="a.duration" class="input w2" type="text"/>
                                </div>
                            </div>
                            <div class="left-right">
                                <div class="block" style="margin-top: 0">
                                    <span>Завершение</span>
                                    <input v-model="a.time_stop" class="input w2" type="text"/>
                                </div>
                                <div class="bottom3">
                                    <div class="block" style="margin-top: 0">
                                        <span>Фикс. время</span>
                                        <input v-model="a.time_fixed" class="input w3" type="text"/>
                                    </div>
                                    <div class="block" style="margin-top: 0">
                                        <span>Стоимость</span>
                                        <input v-model="a.price" class="input w3" type="text" @input="numVerify($event, index)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="save">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>

</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id', 'user_id'],
    data() {
        return {
            tariffs0       : {},
            tariffs1       : {},
            name           : '',
            week_day       : '',
            id_zone        : '',
            booking_alive  : '',
            modal          : null,
            additionalBlock: [],
            zone           : []
        }
    },
    methods: {
        numVerify(e, i) {
            this.additionalBlock[i].price = verifyNum(e);
        },
        async save() {
            this.modal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("name", this.name);
            urlencoded.append("week_day", this.week_day);
            urlencoded.append("id_zone", this.id_zone);
            urlencoded.append("booking_alive", this.booking_alive);
            urlencoded.append("add_block", JSON.stringify(this.additionalBlock));


            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tariff/save", requestOptions);
            if (response.ok) {
                this.get0();
                this.get1();
                var data = {
                    "club_id"      : this.$props.club_id,
                    "name"         : this.name,
                    "week_day"     : this.week_day,
                    "id_zone"      : this.id_zone,
                    "booking_alive": this.booking_alive,
                    "add_block"    : JSON.stringify(this.additionalBlock),
                }
                createLog(JSON.stringify(data), 'Добавление тарифа', 'tariffs', this.$props.user_id);
            } else {
                this.$refs.message.modal.show();
            }
        },
        addModalShow() {
            this.name            = '';
            this.booking_alive   = '';
            this.week_day        = '';
            this.id_zone         = '';
            this.additionalBlock = [];
            this.modal.show();
        },
        encriment() {
            var newAdditionaBlock = {
                time_start: '',
                duration  : '',
                time_stop : '',
                time_fixed: '',
                price     : ''
            };
            this.additionalBlock.push(newAdditionaBlock);
        },
        decriment() {
            if (this.additionalBlock.length > 0)
                this.additionalBlock.splice(this.additionalBlock.length - 1, 1)
        },
        async get0() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("type", 0);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/price/get", requestOptions);
            if (response.ok) {
                this.tariffs0 = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async get1() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("type", 1);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/price/get", requestOptions);
            if (response.ok) {
                this.tariffs1 = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getZone() {
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

            var response = await fetch("api/tariff/zone", requestOptions);
            if (response.ok) {
                this.zone = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var addTariffModal = document.getElementById('addTariffModal')
        this.modal         = bootstrap.Modal.getOrCreateInstance(addTariffModal);

        this.get0();
        this.get1();
        this.getZone();
    }
}
</script>

<style scoped>
.left-right {
    width : 49%;
}

.bottom2 {
    display         : flex;
    justify-content : space-between;
    margin-top      : 20px;
}

.bottom3 {
    display         : flex;
    justify-content : space-between;
}

.modal-body {
    padding : 15px;
}

.block {
    display        : flex;
    flex-direction : column;
    align-items    : flex-start;
    margin-top     : 12px;
}

.w1 {
    width : 465px;
}

.w2 {
    width : 227px;
}

.w3 {
    width : 112px;
}

.input {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 6px;
    color         : var(--standart-gray);
    border        : none;
    border-radius : 8px;
}

.home {
    width       : 1793px;
    height      : 815px;
    color       : var(--standart-gray);
    margin-left : 11px;
}

.home .header {
    display         : flex;
    justify-content : space-between;
}

.home .header .left {
    width : 1060px;
}

.home .header .right {
    width           : 400px;
    display         : flex;
    justify-content : end;
}

.t0, .t1 {
    display : flex;
}

.time-data {
    display   : inline-block;
    font-size : inherit;
}

.tariff-name {
    padding : 0px 0 12px 0;
}

.icon {
    color : var(--light-green)
}

.div_4 {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 1px;
    margin-left   : 10px;
    color         : var(--standart-gray);
    border        : none;
    width         : 190px;
    border-radius : 5px;
    font-size     : inherit;
}

.bottom {
    width         : 1793px;
    height        : 752px;
    background    : var(--light-blue-bg-color);
    margin-top    : 20px;
    border-radius : 20px;
    padding       : 20px;
}

.in-bottom {
    overflow       : auto;
    flex-wrap      : wrap;
    display        : flex;
    max-height     : 809px;
    flex-direction : column;
}

.butt {
    background    : var(--disable);
    border        : none;
    border-radius : 5px 30px;
    height        : 42px;
    margin-left   : 20px;
    min-width     : 94px;
    padding-right : 20px;
    padding-left  : 20px;
}

.top {
    width           : 1490px;
    height          : 42px;
    display         : flex;
    justify-content : start;
    align-items     : center;
}

.goods {
    width         : 178px;
    height        : 281px;
    background    : var(--standart-black);
    margin-right  : 15px;
    padding       : 11px;
    border-radius : 12px;
    margin-bottom : 15px;
    font-size     : 14px;
}

.goods_img {
    width           : 156px;
    height          : 200px;
    display         : flex;
    justify-content : center;
    background      : var(--standart-color);
    overflow        : hidden;
    border-radius   : 10px;
}

.goods_text {
    width       : 156px;
    height      : 22px;
    line-height : 8px;
    margin-top  : 7px;
    font-size   : inherit;
}

.goods-btn {
    width           : 154px;
    height          : 25px;
    display         : flex;
    justify-content : center;
    align-items     : center;
    font-size       : 10px;
    margin-top      : 4px;
}

.goods_cart {
    border        : none;
    border-radius : 4px;
    background    : var(--dark-green);
    color         : var(--standart-color);
    width         : 30px;
    height        : 25px;
}
</style>
