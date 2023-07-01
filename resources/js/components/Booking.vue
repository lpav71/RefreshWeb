<template>
    <div class="div_1">
        <table class="booking-table table-striped">
            <thead>
            <tr>
                <th style="width: 200px"></th>
                <th v-for="t in 24">{{ t-1 }}:00</th>
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
                        <div class="off" :style="{width: f.offset *1.147 + 'px' }"></div><div @click="bModal(index)" class="bar" style="cursor: pointer" :style="{width: f.diff *1.147 + 'px' }"><span>{{ f.f3 }}</span></div>
                    </template>
                    <template v-if="f == null">
                        <div class="off" style="width: 100%"></div>
                    </template>
                </template>
            </td>
        </tr>
    </table>

    <!-- Модальное окно -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Информация о бронировании</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="main_modal">
                        <div class="info_modal" style="margin-top: 26px;">
                            <div class="table-responsive">
                                <table class="table table-borderless user_info_modal">
                                    <tbody>
                                    <tr>
                                        <td><span class="name_modal">Пользователь: </span><span class="value_modal">{{ currentClient.login }}</span></td>
                                        <td><span class="name_modal">Компьютер: </span><span class="value_modal">{{ currentClient.zone }} {{ currentClient.map_comp_id }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Дата: </span><span class="value_modal">{{ currentClient.date }}</span></td>
                                        <td><span class="name_modal">Время: </span><span class="value_modal">{{ currentClient.time_start }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Тариф: </span><span class="value_modal">{{ currentClient.tariff }}</span></td>
                                        <td><span class="name_modal">Источник: </span><span class="value_modal">booking.refresh-software.ru/id3456789</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="name_modal">Оплата: </span><span class="value_modal">Произведена</span></td>
                                        <td><span class="name_modal">Метод оплаты: </span><span class="value_modal">Банковская карта (онлайн)</span></td>
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
                                        <td><span class="name_modal">Номер телефона: </span><span class="value_modal">{{ currentClient.phone }}</span></td>
                                        <td><span class="name_modal">E-mail: </span><span class="value_modal">{{ currentClient.email }} {{ currentClient.map_comp_id }}</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="cancelBooking">Отмена бронирования</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Booking",
    props: ['club_id'],
    data() {
        return {
            maps: [],
            clientList: [],
            currentClient: {},
        }
    },
    methods: {
        async draw() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            const todayFormatted = `${year}-${month}-${day}`;

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append('time_start', todayFormatted);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var resonse = await fetch("api/booking/draw", requestOptions);
            this.maps = await resonse.json();
            var cnt = this.maps.length;
            console.log(cnt);
            var i = 0;
            for (i = 0; i <= 19 - cnt; i++) {
                this.maps.push('');
            }
        },
        bModal(i) {
            this.bookingModal.show();
            this.currentClient = this.clientList[i];
        },
        async getClients() {
            var club_id = JSON.parse(this.$props.club_id);
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/all", requestOptions);
            this.clientList = await response.json();
        },
    },
    mounted() {
        var bookingModal = document.getElementById('bookingModal')
        this.bookingModal = bootstrap.Modal.getOrCreateInstance(bookingModal);

        this.draw();
        this.getClients();
    }
}
</script>

<style scoped>
.off {
    color: yellow;
    display: inline-block;
    height: 10px;
}
.modal-body {
    padding: 0;
}
.main_modal {
    width: 800px;
    height: 314px;
    background: var(--light-blue-bg-color);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.modal-content {
    background: var(--light-blue-bg-color);
    color: var(--standart-gray);
}
.info_modal {
    width: 760px;
    background: var(--dark-blue-bg-color);
    border-radius: 20px;
}

.contact_modal {
    width: 760px;
    height: 60px;
    background: var(--dark-blue-bg-color);
    border-radius: 20px;
    display: flex;
    padding-top: 4px;
    margin-top: 10px;
}

.user_info_modal {
    color: var(--standart-gray);
    margin-top: 10px;
    font-size: 13px;
    width: 90%;
    margin-left: 10px;
}

.user_info_modal td {
    width: 50%;
}

.value_modal {
    color: var(--light-green);
}
.tdata {
    position: absolute;
    top: 122px;
    left: 253px;
}
.tdata tr {
    /*border: 1px solid white;*/
}
.tdata td, .tdata .bar {
    height: 44.8px;
}
.tdata .bar {
    background-color: var(--dark-green);
    border-radius: 5px 30px 5px 30px;
    display: inline-block;
    text-align: center;
    height: 31px;
}
.tdata .bar span {
    display: inline-block;
    margin-top: 4px;
    color: var(--standart-gray);
}
.div_1 {
    width: 1794px;
    height: 900px;
    color: white;
    border-radius: 20px;
    overflow: hidden;
    margin-left: 11px;
}

.booking-table {
    border-radius: 30px;
    color: var(--standart-gray);
}
.booking-table th {
    text-align: center;
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    z-index: 2;
}
.booking-table th:not(:first-child) {
    width: 83px;
}
.booking-table td:nth-child(2n+1) {
    background-color: var(--standart-black)
}
.booking-table th:first-child {
    background: #284f62;
}
.booking-table td:first-child {
    background: #284f62;
    height: 44.2px;
    text-align: center;
    padding-top: 19px;
}

</style>
