<template>
    <div class="main">
        <div class="top">
            <i class="fas fa-dice-d20"></i><span>Промокоды</span>
        </div>
        <div class="bottom">
            <div class="left-right">
                <label>Введите промокод<br><input v-model="promocode" class="input_text" placeholder="Введите промокод" type="text"><a class="gen" href="" @click="autoGen">Сгенирировать автоматически</a></label>
                <label>Начало действия промокода<br><input v-model="data_start" class="input_text" placeholder="Выберите дату" type="text" @click="calendarShowStart"></label>
                <label>Окончание действия промокода<br><input v-model="data_stop" class="input_text" placeholder="Выберите дату" type="text" @click="calendarShowEnd"></label>
                <label>Ограничение активаций<br><input v-model="max_activation" class="input_text" placeholder="Введите количество" type="text" @input="numVerify"></label>
                <label>Размер скидки<br><input v-model="num" class="input_text" placeholder="Введите размер скидки" type="text" @input="numVerifyDouble"></label>
                <label>Комментарий<br><textarea v-model="comment" class="input_text area" placeholder="Опишите мотив промокода" spellcheck="false" type="text"></textarea></label>
                <button class="btn btn-success" @click="save">Создать</button>
            </div>
            <div class="left-right ">
                <div class="right-block">
                    <span>Список промокодов</span><br>
                    <div class="promocods">
                        <table>
                            <thead>
                            <tr>
                                <th>Промокод</th>
                                <th>Период действия</th>
                                <th>Комментарий</th>
                                <th>Количество активаций</th>
                                <th>Статус</th>
                            </tr>
                            </thead>
                            <tr v-for="(p, i) in promocodes">
                                <td style="cursor: pointer" @click="showModalData(i)">{{ p.promo }}</td>
                                <td>{{ p.date_start }} - {{ p.date_stop }}</td>
                                <td>{{ p.description }}</td>
                                <td>{{ p.max_activation }}</td>
                                <td :style="{ color: p.status_color }">{{ p.status_active }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <calendar ref="calandarStart" @item-selected="calendarSelectStart"></calendar>
    <calendar ref="calandarEnd" @item-selected="calendarSelectEnd"></calendar>

    <!-- Модальное окно -->
    <div id="promoModal" aria-hidden="true" aria-labelledby="promoModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="promoModalLabel" class="modal-title">Промокоды</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                        <tr>
                            <th>Активация<br> (дата и время)</th>
                            <th>Промо-код ID</th>
                            <th>Тираж</th>
                            <th>Скидка</th>
                            <th>Активировано</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(f, index) in detail">
                            <td>{{ f.date_d }}</td>
                            <td>{{ f.promo }}</td>
                            <td>{{ f.max_activation }}</td>
                            <td>{{ f.num }}</td>
                            <td>{{ f.activations }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
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
            promocodes    : [],
            promocode     : '',
            data_start    : '',
            data_stop     : '',
            num           : '',
            comment       : '',
            max_activation: '',
            promoModal    : null,
            detail        : []
        }
    },
    methods: {
        numVerify(e) {
            this.max_activation = verifyNum(e);
        },
        numVerifyDouble(e) {
            this.num = verifyNumDouble(e);
        },
        calendarSelectStart() {
            var day         = this.$refs.calandarStart.selectedDay;
            var month       = this.$refs.calandarStart.currentMonth + 1;
            var year        = this.$refs.calandarStart.currentYear;
            var date        = new Date(year, month - 1, day);
            this.data_start = formatDate(date);
            this.$refs.calandarStart.hide();
        },
        calendarSelectEnd() {
            var day        = this.$refs.calandarEnd.selectedDay;
            var month      = this.$refs.calandarEnd.currentMonth + 1;
            var year       = this.$refs.calandarEnd.currentYear;
            var date       = new Date(year, month - 1, day);
            this.data_stop = formatDate(date);
            this.$refs.calandarEnd.hide();
        },
        calendarShowStart() {
            this.$refs.calandarStart.top  = 340;
            this.$refs.calandarStart.left = 252;
            this.$refs.calandarStart.show();
        },
        calendarShowEnd() {
            this.$refs.calandarEnd.top  = 422;
            this.$refs.calandarEnd.left = 252;
            this.$refs.calandarEnd.show();
        },
        autoGen(e) {
            e.preventDefault();
            this.promocode = (Math.random() + 1).toString(36).substring(2);
        },
        async save() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("promo", this.promocode);
            urlencoded.append("description", this.comment);
            urlencoded.append("date_start", this.data_start);
            urlencoded.append("date_stop", this.data_stop);
            urlencoded.append("max_activation", this.max_activation);
            urlencoded.append("num", this.num);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/promo/save", requestOptions);
            if (response.ok) {
                this.promocode  = '';
                this.comment    = '';
                this.data_start = '';
                this.data_stop  = '';
                this.num        = 0;
                this.getPromo();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getPromo() {
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

            var response = await fetch("api/promo/get", requestOptions);
            if (response.ok) {
                this.promocodes = await response.json();
                this.promocodes.forEach(function (item, index) {
                    if (item.status == true) {
                        this.promocodes[index].status_active = 'Активен';
                        this.promocodes[index].status_color  = 'green';
                    } else {
                        this.promocodes[index].status_active = 'Просрочен';
                        this.promocodes[index].status_color  = '#cc5a5a';
                    }
                }.bind(this))
            } else {
                this.$refs.message.modal.show();
            }
        },
        async showModalData(i) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("promo_id", this.promocodes[i].id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/promo/details", requestOptions);
            if (response.ok) {
                this.detail = await response.json();
                this.promoModal.show();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var promoModal  = document.getElementById('promoModal')
        this.promoModal = bootstrap.Modal.getOrCreateInstance(promoModal);

        this.getPromo();
    }
}
</script>

<style scoped>
.modal-body {
    padding : 15px;
}

.btn {
    width      : 130px;
    margin-top : 30px;
}

.gen {
    text-decoration : none;
    color           : var(--light-green);
    margin-left     : 20px;
}

.promocods {
    overflow-x : auto;
    height     : 580px;
}

table {
    color      : var(--standart-gray);
    text-align : center;
    width      : 100%;
}

th {
    width          : 20%;
    padding-bottom : 20px;
    padding-top    : 20px;
    font-weight    : normal;
}

td {
    padding-bottom : 10px;
    padding-top    : 10px;
}

thead {
    border-bottom-width : 1px;
    border-bottom-style : solid;
}

.main {
    width       : 1794px;
    height      : 815px;
    margin-left : 12px;
    color       : var(--standart-gray);
}

.top {
    height      : 60px;
    padding-top : 14px;
}

.top span {
    display     : inline-block;
    margin-left : 12px;
}

.bottom {
    height        : 754px;
    background    : var(--light-blue-bg-color);
    border-radius : 20px;
    display       : flex;
}

.left-right {
    width          : 50%;
    display        : flex;
    flex-direction : column;
    padding        : 10px 30px 30px 30px;
}

.left-right label {
    margin-top : 15px;
}

.input_text {
    height        : 35px;
    background    : var(--bg);
    padding       : 5px 15px 5px 15px;
    margin-top    : 10px;
    color         : var(--standart-gray);
    border        : none;
    width         : 340px;
    border-radius : 8px;
}

.area {
    height : 100px !important;
}

.right-block {
    background    : var(--bg);
    width         : 100%;
    height        : 97%;
    margin-top    : 20px;
    border-radius : 20px;
    padding       : 30px;
}
</style>
