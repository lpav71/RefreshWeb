<template>
    <div class="home">
        <div class="header_left">
            <img alt="" class="left-icon" src="img/6.svg">
            <span class="lbl">Бронирование</span>
            <label for="start">Выберите дату</label>
            <input id="start" v-model="start_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowStart">
            <button class="btn btn-success" @click="draw">Показать</button>
        </div>

        <div class="div_1">
            <table class="booking-table table-striped">
                <thead>
                <tr>
                    <th style="width: 200px"></th>
                    <th v-for="t in 24">{{ t - 1 }}:00</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(t, index) in maps">
                    <td>{{ t.id_comp }}</td>
                    <td v-for="t in 24">&emsp;</td>
                </tr>
                </tbody>
            </table>
        </div>

        <table class="tdata">
            <tr v-for="m in maps">
                <td style="color: white">
                    <template v-for="(f, index) in m.fulldata">
                        <template v-if="f != null">
                            <div :style="{width: f.offset *1.147 + 'px' }" class="off"></div>
                            <div :style="{width: f.diff *1.147 + 'px' }" class="bar" style="cursor: pointer" @click="bModal(index)">
                                <span>{{ f.f3 }}</span></div>
                        </template>
                        <template v-if="f == null">
                            <div class="off" style="width: 100%"></div>
                        </template>
                    </template>
                </td>
            </tr>
        </table>
    </div>

    <calendar ref="calandarStart" @item-selected="calendarSelectStart"></calendar>

    <!-- Модальное окно -->
    <div id="bookingModal" aria-hidden="true" aria-labelledby="bookingModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="bookingModalLabel" class="modal-title">Информация о бронировании</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="main_modal">
                        <div class="info_modal" style="margin-top: 26px;">
                            <div class="table-responsive">
                                <table class="table table-borderless user_info_modal">
                                    <tbody>
                                    <tr>
                                        <td><span class="name_modal">Пользователь: </span><span class="value_modal">{{ currentClient.login }}</span>
                                        </td>
                                        <td>
                                            <span class="name_modal">Компьютер: </span><span class="value_modal">{{ currentClient.zone }} {{ currentClient.map_comp_id }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Дата: </span><span class="value_modal">{{ currentClient.date }}</span></td>
                                        <td><span class="name_modal">Время: </span><span class="value_modal">{{ currentClient.time_start }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Тариф: </span><span class="value_modal">{{ currentClient.tariff }}</span></td>
                                        <td>
                                            <span class="name_modal">Источник: </span><span class="value_modal">booking.refresh-software.ru/id3456789</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Оплата: </span><span class="value_modal">Произведена</span></td>
                                        <td><span class="name_modal">Метод оплаты: </span><span class="value_modal">Банковская карта (онлайн)</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="margin-top: 20px;"><span>Контактная информация</span>
                            <div class="contact_modal">
                                <table class="table table-borderless user_info_modal">
                                    <tbody>
                                    <tr>
                                        <td><span class="name_modal">Номер телефона: </span><span class="value_modal">{{ currentClient.phone }}</span>
                                        </td>
                                        <td>
                                            <span class="name_modal">E-mail: </span><span class="value_modal">{{ currentClient.email }} {{ currentClient.map_comp_id }}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="cancelBooking">Отмена бронирования</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>
</template>

<script>

export default {
    name : "Booking",
    props: ['club_id'],
    data() {
        return {
            maps         : [],
            clientList   : [],
            currentClient: {},
            start_date   : '',
        }
    },
    methods: {
        calendarSelectStart() {
            var day         = this.$refs.calandarStart.selectedDay;
            var month       = this.$refs.calandarStart.currentMonth + 1;
            var year        = this.$refs.calandarStart.currentYear;
            var date        = new Date(year, month - 1, day);
            this.start_date = formatDate(date);
            this.$refs.calandarStart.hide();
        },
        calendarShowStart(e) {
            this.$refs.calandarStart.top  = e.pageY;
            this.$refs.calandarStart.left = e.pageX;
            this.$refs.calandarStart.show();
        },
        async draw() {
            let dateArray = this.start_date.split('.'); // разделение строки по точке
            dateArray.reverse(); // изменение порядка элементов массива
            const today = new Date(dateArray[0], dateArray[1] - 1, dateArray[2]);

            const year           = today.getFullYear();
            const month          = (today.getMonth() + 1).toString().padStart(2, '0');
            const day            = today.getDate().toString().padStart(2, '0');
            const todayFormatted = `${year}-${month}-${day}`;

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append('time_start', todayFormatted);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var resonse = await fetch("api/booking/draw", requestOptions);
            if (resonse.ok) {
                this.maps = await resonse.json();
                var cnt   = this.maps.length;
                var i     = 0;
                for (i = 0; i <= 15 - cnt; i++) {
                    this.maps.push('');
                }
            } else {
                this.$refs.message.modal.show();
            }
        },
        bModal(i) {
            this.bookingModal.show();
            this.currentClient = this.clientList[i];
        },
        async getClients() {
            var club_id   = JSON.parse(this.$props.club_id);
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/all", requestOptions);
            if (response.ok) {
                this.clientList = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
    },
    mounted() {
        var bookingModal  = document.getElementById('bookingModal')
        this.bookingModal = bootstrap.Modal.getOrCreateInstance(bookingModal);

        this.getClients();
    }
}
</script>

<style scoped>
.home {
    height : 815px;
}

.left-icon {
    width       : 23px;
    margin-left : 10px;
}

.header_left {
    display       : flex;
    color         : var(--standart-gray);
    align-items   : center;
    gap           : 17px;
    margin-bottom : 17px;
}

.input_1 {
    background    : var(--light-blue-bg-color);
    box-shadow    : 0 1px 10px rgba(0, 0, 0, 0.12);
    border-radius : 10px;
    border        : none;
    padding       : 5px;
    margin-top    : 5px;
    color         : white;
    width         : 190px;
    height        : 40px;
    cursor        : pointer;
}

.off {
    color   : yellow;
    display : inline-block;
    height  : 10px;
}

.modal-body {
    padding : 0;
}

.main_modal {
    width          : 800px;
    height         : 314px;
    background     : var(--light-blue-bg-color);
    display        : flex;
    flex-direction : column;
    align-items    : center;
}

.modal-content {
    background : var(--light-blue-bg-color);
    color      : var(--standart-gray);
}

.info_modal {
    width         : 760px;
    background    : var(--dark-blue-bg-color);
    border-radius : 20px;
}

.contact_modal {
    width         : 760px;
    height        : 60px;
    background    : var(--dark-blue-bg-color);
    border-radius : 20px;
    display       : flex;
    padding-top   : 4px;
    margin-top    : 10px;
}

.user_info_modal {
    color       : var(--standart-gray);
    margin-top  : 10px;
    font-size   : 13px;
    width       : 90%;
    margin-left : 10px;
}

.user_info_modal td {
    width : 50%;
}

.value_modal {
    color : var(--light-green);
}

.tdata {
    position : absolute;
    top      : 186px;
    left     : 253px;
}

.tdata td, .tdata .bar {
    height : 45.5px;
}

.tdata .bar {
    background    : var(--regular);
    border-color  : var(--regular);
    border-radius : 12px;
    display       : inline-block;
    text-align    : center;
    height        : 31px;
}

.tdata .bar span {
    display    : inline-block;
    margin-top : 4px;
    color      : white;
}

.div_1 {
    width         : 1794px;
    height        : 752px;
    color         : white;
    border-radius : 20px;
    overflow      : hidden;
    margin-left   : 11px;
}

.booking-table {
    border-radius : 30px;
    color         : var(--standart-gray);
}

.booking-table th {
    text-align : center;
    position   : -webkit-sticky;
    position   : sticky;
    top        : 0;
    z-index    : 2;
}

.booking-table th:not(:first-child) {
    width : 83px;
}

.booking-table td:nth-child(2n+1) {
    background-color : var(--standart-black)
}

.booking-table th:first-child {
    background : #284f62;
}

.booking-table td:first-child {
    background  : #284f62;
    height      : 45.6px;
    text-align  : center;
    padding-top : 19px;
}

</style>
