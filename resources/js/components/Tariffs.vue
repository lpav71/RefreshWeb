<template>
<div class="home">
    <div class="header">
        <div class="left">
            <div class="top"><img src="img/4.svg" alt=""/><span style="margin-left: 14px;">Тарифы и предложения</span>
            </div>
        </div>
        <div class="right">
            <button @click="addModalShow" class="butt" type="button">Добавить</button>
        </div>
    </div>
    <div class="bottom">
        <div class="in-bottom">

            <div class="tariff-name">
                <span style="margin-right: 10px">Поминутный</span>
                <i class="far fa-clock icon"></i>
                <select class="div_4">
                    <option value="" disabled selected>Выберите тариф</option>
                    <option v-for="t in 3">Value</option>
                </select>
            </div>
            <div class="t0">
                <div class="goods" v-for="(g, index) in tariffs0">
                    <div class="goods_img"><img src="images/tariff.png" height="200" alt=""></div>
                    <div class="goods_text">
                        <div class="time-data">{{ g.time_start }} {{ g.time_stop }}</div><div class="time-data">&emsp;{{ g.price }}р/мин</div>
                    </div>
                    <div class="goods-btn">
                        <span style="font-size: 15px">{{ g.name }}&emsp;</span>
                        <button class="goods_cart" @click="editModal(index)" type="button"><i class="fa fa-edit fa-lg"></i></button>
                    </div>
                </div>
            </div>

            <div class="tariff-name">
                <span style="margin-right: 10px">Пакетное предложение</span>
                <i class="far fa-clock icon"></i>
                <select class="div_4">
                    <option value="" disabled selected>Выберите тариф</option>
                    <option v-for="t in 3">Value</option>
                </select>
            </div>
            <div class="t0">
                <div class="goods" v-for="(g, index) in tariffs1">
                    <div class="goods_img"><img src="images/tariff.png" height="200" alt=""></div>
                    <div class="goods_text">
                        <div class="time-data">{{ g.time_start }} {{ g.time_stop }}</div><div class="time-data">&emsp;{{ g.price }}р/мин</div>
                    </div>
                    <div class="goods-btn">
                        <span style="font-size: 15px">{{ g.name }}&emsp;</span>
                        <button class="goods_cart" @click="editModal(index)" type="button"><i class="fa fa-edit fa-lg"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    <!-- Модальное окно -->
    <div class="modal fade" id="addTariffModal" tabindex="-1" aria-labelledby="addTariffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTariffModalLabel">Новый тариф</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="block" style="margin-top: 0">
                        <span>Тариф</span>
                        <input type="text" class="input w1" placeholder="Введите наименование" v-model="name" />
                    </div>
                    <div class="bottom2">
                        <div class="left-right">
                            <div class="block" style="margin-top: 0">
                                <span>День недели</span>
                                <select class="input w2" v-model="week_day">
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
                                <input type="text" class="input w2" v-model="booking_alive" />
                            </div>
                        </div>
                        <div class="left-right">
                            <div class="block" style="margin-top: 0">
                                <span>Зона</span>
                                <select class="input w2" v-model="id_zone">
                                    <option v-for="z in zone" :value="z.num">{{ z.name }}</option>
                                </select>
                            </div>
                            <button class="btn bt" @click="encriment"> + </button>
                            <button class="btn bt" @click="decriment"> - </button>
                        </div>
                    </div>
                    <template v-for="(a, index) in additionalBlock">
                        <div class="bottom2">
                            <div class="left-right">
                                <div class="block" style="margin-top: 0">
                                    <span>Начало</span>
                                    <input type="text" class="input w2" v-model="a.time_start" />
                                </div>
                                <div class="block" style="margin-top: 0">
                                    <span>Продолжительность</span>
                                    <input type="text" class="input w2" v-model="a.duration" />
                                </div>
                            </div>
                            <div class="left-right">
                                <div class="block" style="margin-top: 0">
                                    <span>Завершение</span>
                                    <input type="text" class="input w2" v-model="a.time_stop" />
                                </div>
                                <div class="bottom3">
                                    <div class="block" style="margin-top: 0">
                                        <span>Фикс. время</span>
                                        <input type="text" class="input w3" v-model="a.time_fixed" />
                                    </div>
                                    <div class="block" style="margin-top: 0">
                                        <span>Стоимость</span>
                                        <input type="text" class="input w3" v-model="a.price" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-green" @click="save">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>

</template>

<script>
export default {
    props: ['club_id'],
    data() {
        return {
            tariffs0: {},
            tariffs1: {},
            name: '',
            week_day: '',
            id_zone: '',
            booking_alive: '',
            modal: null,
            additionalBlock: [],
            zone: []
        }
    },
    methods: {
        async save() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("name", this.name);
            urlencoded.append("week_day", this.week_day);
            urlencoded.append("id_zone", this.id_zone);
            urlencoded.append("booking_alive", this.booking_alive);
            urlencoded.append("add_block", JSON.stringify( this.additionalBlock));


            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tariff/save", requestOptions);
            if (response.ok) {
                this.modal.hide();
                this.get0();
                this.get1();
            }
            else {
                this.$refs.message.modal.show();
            }
        },
        addModalShow() {
            this.name = '';
            this.booking_alive = '';
            this.week_day = '';
            this.id_zone = '';
            this.additionalBlock = [];
            this.modal.show();
        },
        encriment() {
            var newAdditionaBlock = {
                time_start: '',
                duration: '',
                time_stop: '',
                time_fixed: '',
                price: ''
            };
            this.additionalBlock.push(newAdditionaBlock);
        },
        decriment() {
            if(this.additionalBlock.length > 0)
                this.additionalBlock.splice(this.additionalBlock.length-1, 1)
        },
        async get0() {
           var myHeaders = new Headers();
           myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

           var urlencoded = new URLSearchParams();
           urlencoded.append("club_id", this.$props.club_id);

           var requestOptions = {
               method: 'POST',
               headers: myHeaders,
               body: urlencoded,
               redirect: 'follow'
           };

           var response = await fetch("api/price/get0", requestOptions);
           this.tariffs0 = await response.json();
        },
        async get1() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/price/get1", requestOptions);
            this.tariffs1 = await response.json();
        },
        async getZone() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tariff/zone", requestOptions);
            this.zone = await response.json();
        }
    },
    mounted() {
        var addTariffModal = document.getElementById('addTariffModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(addTariffModal);

        this.get0();
        this.get1();
        this.getZone();
    }
}
</script>

<style scoped>
.left-right {
    width: 49%;
}
.bottom2{
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
.bottom3 {
    display: flex;
    justify-content: space-between;
}
.modal-body {
    padding: 15px;
}
.btn-green {
    background: var(--light-green);
}
.block {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 12px;
}
.bt {
    background: var(--light-green);
    border-radius: 5px 15px 5px 15px;
    margin-top: 26px;
    margin-right: 20px;
}
.w1 {
    width: 465px;
}
.w2 {
    width: 227px;
}
.w3 {
    width: 112px;
}
.input {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 6px;
    color: var(--standart-gray);
    border: none;
    border-radius: 8px;
}
.home {
    width: 1793px;
    height: 947px;
    color: var(--standart-gray);
    margin-left: 11px;
}
.home .header {
    display: flex;
    justify-content: space-between;
}
.home .header .left {
    width: 1060px;
}
.home .header .right {
    width: 400px;
    display: flex;
    justify-content: end;
}
.t0, .t1 {
    display: flex;
}
.time-data {
    display: inline-block;
    font-size: inherit;
}
.tariff-name {
    padding: 20px 0 20px 0;
}
.icon {
    color: var(--light-green)
}
.div_4 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 1px;
    margin-left: 10px;
    color: var(--standart-gray);
    border: none;
    width: 190px;
    border-radius: 8px 26px;
    font-size: inherit;
}
.bottom {
    width: 1793px;
    height: 855px;
    background: var(--light-blue-bg-color);
    margin-top: 20px;
    border-radius: 20px;
    padding: 20px;
}
.in-bottom {
    overflow: auto;
    flex-wrap: wrap;
    display: flex;
    max-height: 809px;
    flex-direction: column;
}
.butt {
    background: var(--disable);
    border: none;
    border-radius: 5px 30px;
    height: 42px;
    margin-left: 20px;
    min-width: 94px;
    padding-right: 20px;
    padding-left: 20px;
}
.top {
    width: 1490px;
    height: 42px;
    display: flex;
    justify-content: start;
    align-items: center;
}
.goods {
    width: 178px;
    height: 281px;
    background: var(--standart-black);
    margin-right: 15px;
    padding: 11px;
    border-radius: 12px;
    margin-bottom: 15px;
    font-size: 14px;
}

.goods_img {
    width: 156px;
    height: 200px;
    display: flex;
    justify-content: center;
    background: var(--standart-color);
    overflow: hidden;
    border-radius: 10px;
}

.goods_text {
    width: 156px;
    height: 22px;
    line-height: 8px;
    margin-top: 7px;
    font-size: inherit;
}

.goods-btn {
    width: 154px;
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10px;
    margin-top: 4px;
}

.goods_cart {
    border: none;
    border-radius: 4px;
    background: var(--dark-green);
    color: var(--standart-color);
    width: 30px;
    height: 25px;
}
</style>
