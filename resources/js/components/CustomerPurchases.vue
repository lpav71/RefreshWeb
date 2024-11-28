<template>
    <div class="home">
        <a ref="csvfile" :href="filename" download="" style="display: none">{{ filename }}</a>
        <div class="header_bottom">
            <div class="header_bottom_left">
                <div class="contact_link">
                    <img alt="" src="/images/head_bottom/contact.svg"/>
                    Покупки клиентов
                </div>
                <div class="filter">
                    <label for="start">Начало периода</label>
                    <input id="start" v-model="start_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowStart">

                    <label for="end">Конец периода</label>
                    <input id="end" v-model="end_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowEnd">

                    <label for="admin">Администратор</label>
                    <select id="admin" v-model="admin" class="select-admin">
                        <option value="-1">Все</option>
                        <option v-for="a in admins" :value="a.id">{{ a.name }}</option>
                    </select>&emsp;
                    <label for="client">Клиент</label>
                    <select id="client" v-model="client" class="select-admin">
                        <option value="-1">Все</option>
                        <option v-for="a in clients" :value="a.id">{{ a.login }}</option>
                    </select>

                    <button class="btn btn-success" @click="filter">Фильтр</button>
                    <button class="btn btn-success" @click="getPurchases">Сбросить</button>
                    <button class="btn btn-success" @click="generateReport"><img alt="" src="img/download-bold.svg" style="margin-bottom: 5px;">
                    </button>
                </div>
            </div>
        </div>

        <table class="table table-borderless t1" style="margin-top: 20px;">
            <thead>
            <tr>
                <th style="width: 179px">Дата\время покупки</th>
                <th style="width: 179px">Вид оплаты</th>
                <th style="width: 179px">Доставка</th>
                <th style="width: 179px">Выполнена доставка</th>
                <th style="width: 179px">Единиц товара</th>
                <th style="width: 179px">Номер смены</th>
                <th style="width: 179px">Сумма</th>
                <th style="width: 179px">Администратор</th>
                <th style="width: 179px">Клиент</th>
                <th style="width: 179px">Номер ПК</th>
            </tr>
            </thead>
        </table>
        <div class="fon">
            <table class="table table-borderless t2" style="cursor: pointer">
                <tbody>
                <tr v-for="(p, index) in purchasesFull" @click="details(index)">
                    <td style="width: 179px">{{ p.datetime }}</td>
                    <td style="width: 179px">{{ p.pay_type }}</td>
                    <td style="width: 179px">{{ p.delivery }}</td>
                    <td v-if="p.delivery_bool" style="width: 179px; text-align: center">
                        <button class="btn btn-success" @click="delivery($event, index)">{{ p.delivery_complete }}</button>
                    </td>
                    <td v-if="!p.delivery_bool" style="width: 179px; text-align: center">Да</td>
                    <td style="width: 179px; text-align: center">{{ p.product_num }}</td>
                    <td style="width: 179px; text-align: center">{{ p.shift }}</td>
                    <td style="width: 179px">{{ p.amount }}</td>
                    <td style="width: 179px">{{ p.name }}</td>
                    <td style="width: 179px">{{ p.login }}</td>
                    <td style="width: 179px">{{ p.comp_id }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Модальное окно Подробно -->
        <div id="detailModal" aria-hidden="true" aria-labelledby="detailModalLabel" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="detailModalLabel" class="modal-title">Подробно</h5>
                        <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Параметр</th>
                                <th>Цена</th>
                                <th>Количество</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(f, index) in detailsData">
                                <td>{{ f.product }}</td>
                                <td>{{ f.product_param }}</td>
                                <td>{{ f.amount }}</td>
                                <td>{{ f.num }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" data-bs-dismiss="modal" type="button">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <calendar ref="calandarStart" @item-selected="calendarSelectStart"></calendar>
        <calendar ref="calandarEnd" @item-selected="calendarSelectEnd"></calendar>
        <message ref="message"></message>
    </div>
</template>

<script>

export default {
    props: ['club_id'],
    data() {
        return {
            purchases    : [],
            purchasesFull: [],
            admins       : [],
            admin        : '-1',
            clients      : [],
            client       : '-1',
            start_date   : '',
            end_date     : '',
            detailModal  : null,
            detailsData  : [],
            filename     : ''
        }
    },
    methods: {
        async delivery(event, i) {
            event.stopPropagation();

            var id        = this.purchasesFull[i].id;
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/clients/delivery", requestOptions);
            if (response.ok) {
                this.getPurchases();
            }
        },
        async generateReport() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");
            var raw = JSON.stringify({
                "collection": this.purchasesFull,
                "header"    : "id,Дата\\время покупки, Вид оплаты, Доставка, Выполнена доставка, Единиц товара, Номер смены, Сумма, Администратор, Клиент"
            });

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : raw,
                redirect: 'follow'
            };

            var response = await fetch("api/export", requestOptions);
            if (response.ok) {
                this.filename = await response.text();
                this.filename = 'CSV/' + this.filename;
                setTimeout(function () {
                    this.$refs.csvfile.click();
                }.bind(this), 500)
            }
        },
        async details(i) {
            this.detailModal.show();
            var urlencoded = new URLSearchParams();
            urlencoded.append("id", this.purchasesFull[i].id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/purchases/details", requestOptions);
            if (response.ok) {
                this.detailsData = await response.json();
            }
        },
        calendarSelectStart() {
            var day         = this.$refs.calandarStart.selectedDay;
            var month       = this.$refs.calandarStart.currentMonth + 1;
            var year        = this.$refs.calandarStart.currentYear;
            var date        = new Date(year, month - 1, day);
            this.start_date = formatDate(date);
            this.$refs.calandarStart.hide();
        },
        calendarSelectEnd() {
            var day       = this.$refs.calandarEnd.selectedDay;
            var month     = this.$refs.calandarEnd.currentMonth + 1;
            var year      = this.$refs.calandarEnd.currentYear;
            var date      = new Date(year, month - 1, day);
            this.end_date = formatDate(date);
            this.$refs.calandarEnd.hide();
        },
        calendarShowStart() {
            this.$refs.calandarStart.top  = start.offsetTop + 50;
            this.$refs.calandarStart.left = start.offsetLeft;
            this.$refs.calandarStart.show();
        },
        calendarShowEnd() {
            this.$refs.calandarEnd.top  = end.offsetTop + 50;
            this.$refs.calandarEnd.left = end.offsetLeft;
            this.$refs.calandarEnd.show();
        },
        async getAdmins() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/admins", requestOptions);
            if (response.ok) {
                this.admins = await response.json();
            }
        },
        async getClients() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/clients", requestOptions);
            if (response.ok) {
                this.clients = await response.json();
            }
        },
        async getPurchases() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/clients/purchases", requestOptions);
            if (response.ok) {
                this.purchases = await response.json();
                this.convertPurchases();
                this.start_date = '';
                this.end_date   = '';
                this.admin      = '-1';
                this.client     = '-1';
            }
        },
        async filter() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("start_date", this.start_date);
            urlencoded.append("end_date", this.end_date);
            urlencoded.append("admin_id", this.admin);
            urlencoded.append("client_id", this.client);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/purchases/filter", requestOptions);
            if (response.ok) {
                this.purchases = await response.json();
                this.convertPurchases();
            }
        },
        convertPurchases() {
            this.purchasesFull = [];
            this.purchases.forEach(function (item, index) {
                var temp = {
                    id               : item.id,
                    datetime         : item.datetime,
                    pay_type         : item.pay_type = 0 ? "C основного счёта" : "с бонусного счёта",
                    delivery_bool    : item.delivery,
                    delivery         : item.delivery ? "Требуется" : "Не требуется",
                    delivery_complete: item.delivery_complete ? "Да" : "Нет",
                    product_num      : item.product_num,
                    shift            : item.shift,
                    amount           : item.amount,
                    name             : item.name,
                    login            : item.login,
                    comp_id          : item.comp_id
                };
                this.purchasesFull.push(temp);
            }.bind(this))
        }
    },
    mounted() {
        var detailModal  = document.getElementById('detailModal')
        this.detailModal = bootstrap.Modal.getOrCreateInstance(detailModal);

        this.getPurchases();
        this.getAdmins();
        this.getClients();
    }
}

</script>

<style lang="scss" scoped>

.t2 {
    margin-top    : 13px;
    border-radius : 15px;
    overflow      : hidden;
}

.t1 th {
    font-weight    : normal;
    text-align     : center;
    padding        : 10px;
    vertical-align : middle;
}

.t1 th:not(:last-child) {
    border-right-width : 1px;
    border-right-style : solid;
    border-color       : #4d4d4d;
}

.t2 td {
    text-align : center;
    padding    : 10px;
}

.t2 td:not(:last-child) {
    border-right-width : 1px;
    border-right-style : solid;
    border-color       : #4d4d4d;
}

.t1 {
    border-radius : 15px;
    overflow      : hidden;
}

.modal-body {
    padding : 15px;

    table {
        width   : 100%;
        padding : 5px;

        thead tr th {
            padding : 8px;
        }

        tr td {
            padding : 8px;
        }
    }
}

.filter {
    margin-bottom   : 4px;
    width           : 100rem;
    display         : flex;
    justify-content : space-between;
    align-items     : center;
}

.input_1 {
    background    : var(--light-blue-bg-color);
    box-shadow    : 0 1px 10px rgba(0, 0, 0, 0.12);
    border-radius : 10px;
    border        : none;
    padding       : 5px;
    margin-top    : 5px;
    color         : white;
    width         : 140px;
    height        : 40px;
    cursor        : pointer;
}

.select-admin {
    background    : var(--light-blue-bg-color);
    width         : 170px;
    color         : var(--standart-gray);
    margin-right  : 10px;
    border        : none;
    border-radius : 10px;
    padding       : 5px;
    margin-top    : 5px;
    height        : 40px;
    cursor        : pointer;
}

select option {
    margin      : 40px;
    background  : #122834;
    color       : var(--standart-gray);
    text-shadow : 0 1px 0 rgba(0, 0, 0, 0.4);
}

.modal-header ~ h5 {
    display : inline-block;
}

.t1 {
    margin-bottom : 20px;
    background    : var(--light-blue-bg-color);
    line-height   : 36px;
}

.reservation-table thead tr th {
    padding       : 10px;
    border-bottom : 1px solid white;
}

.reservation-table tbody tr {
    border-bottom : 1px solid white;
}

.reservation-table tbody tr td {
    padding : 10px;
}

.bt {
    margin-right : 10px;
}

.fon {
    height        : 637px;
    background    : var(--light-blue-bg-color);
    border-radius : 10px;
    overflow      : auto;
}

.check-1 + label {
    display     : inline-flex;
    align-items : center;
    user-select : none;
}

.check-1 + label::after {
    content             : '';
    display             : inline-block;
    width               : 1em;
    height              : 1em;
    flex-shrink         : 0;
    flex-grow           : 0;
    border              : 1px solid #adb5bd;
    border-radius       : 0.3em;
    margin-right        : 0.5em;
    background-repeat   : no-repeat;
    background-position : center center;
    background-size     : 50% 50%;
    left                : 207px;
    position            : absolute;
}

.check-1:checked + label::after {
    border-color     : #0b76ef;
    background-color : #0b76ef;
    background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.check-2 + label {
    display     : inline-flex;
    align-items : center;
    user-select : none;
}

.check-2 + label::after {
    content             : '';
    display             : inline-block;
    width               : 1em;
    height              : 1em;
    flex-shrink         : 0;
    flex-grow           : 0;
    border              : 1px solid #adb5bd;
    border-radius       : 0.25em;
    margin-right        : 0.5em;
    background-repeat   : no-repeat;
    background-position : center center;
    background-size     : 50% 50%;
    left                : 416px;
    position            : absolute;
}

.check-2:checked + label::after {
    border-color     : #0b76ef;
    background-color : #0b76ef;
    background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

/* ------------------------------------------- */
.menu_bottom svg {
    margin-top : 20px;
}

nav {
    display : flex;
}

nav {
    width   : 100%;
    padding : 0 20px;
}

.search-user {
    background : #162c38;
    color      : #f6f6f7;
    padding    : 8px;
    border     : none;
}

.header_top .head_left .head_search button {
    border     : none;
    background : transparent;
    outline    : none;
}

.header_top .head_left .head_search button img {
    max-width : 16px;
}

.header_top .head_left .head_search input {
    width       : 100%;
    background  : transparent;
    border      : none;
    outline     : none;
    margin-left : 10px;
    font-style  : normal;

    font-size   : 16px;
    line-height : 22px;
    color       : #c6c6c6;
}

.header_top .head_left .head_search input::placeholder {
    opacity : 0.5;
}

.head_contact span {
    background    : var(--light-green);
    width         : 23px;
    height        : 23px;
    border-radius : 10px;
    display       : block;
    position      : relative;
    left          : 17px;
    top           : -40px;
}

.header_top .head_right .head_link img {
    max-width : 32px;
}

.header_top .head_right .head_link span {
    position        : absolute;
    background      : #61babe;
    border-radius   : 100px;
    width           : 15px;
    height          : 15px;
    font-family     : "Montserrat", sans-serif;
    font-style      : normal;

    font-size       : 8px;
    line-height     : 22px;
    color           : #fff;
    display         : flex;
    justify-content : center;
    align-items     : center;
    top             : 13px;
    right           : 12px;
}

.header_top .head_right .head_ava .head_ava_title h2 {
    font-style    : normal;

    font-size     : 16px;
    line-height   : 22px;
    color         : #f6f6f7;
    margin-bottom : 0;
}

.header_top .head_right .head_ava .head_ava_title p {
    margin-bottom : 0;
    font-style    : normal;

    font-size     : 14px;
    line-height   : 22px;
    color         : #c6c6c6;
}

.header_top .head_right .dropdown-menu .dropdown-item {
    display : flex;
}

.header_top .head_right .dropdown-menu .dropdown-item:hover {
    background : var(--table-bg);
}

.header_top .head_right .dropdown-menu .dropdown-item img {
    height : 35px;
}

.header_top .head_right .dropdown-menu .dropdown-item {
    margin-left : 0;
}

.header_top .head_right .dropdown-menu .dropdown-item .head_ava_title h2 {
    font-style    : normal;

    font-size     : 12px;
    line-height   : 18px;
    color         : #f6f6f7;
    margin-bottom : 0;
}

.header_top .head_right .dropdown-menu .dropdown-item .head_ava_title p {
    margin-bottom : 0;
    font-style    : normal;

    font-size     : 10px;
    line-height   : 18px;
    color         : #c6c6c6;
}

.home {
    width       : 1793px;
    margin-left : 13px;
    position    : relative;
    height      : 815px;
}

.home .header_bottom {
    //display: flex;
    //justify-content: space-between;
    //align-items: center;
}

.home .header_bottom .header_bottom_left {
    display     : flex;
    align-items : center;
    gap         : 10px;
}

.home .header_bottom .header_bottom_left .contact_link {
    display         : inline-block;
    align-items     : center;
    line-height     : 22px;
    color           : #f6f6f7;
    text-decoration : none;
    padding         : 10px;
    width           : 14rem;
    margin-bottom   : 6px;
}

.home .header_bottom .header_bottom_left .contact_link img {
    margin-right : 10px;
}

.home .header_bottom .header_bottom_left .search_bottom input {
    background  : transparent;
    border      : none;
    outline     : none;
    font-style  : normal;
    font-size   : 16px;
    line-height : 22px;
    color       : #c6c6c6;
}

.home .header_bottom .header_bottom_left .search_bottom input::placeholder {
    opacity : 0.5;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .btn_select {
    padding       : 10px 20px;
    background    : #338c90;
    border-radius : 5px 30px;
    border        : none;
    font-style    : normal;

    font-size     : 16px;
    line-height   : 22px;
    color         : #f6f6f7;
    transition    : 0.4s;
    display       : flex;
    align-items   : center;
    gap           : 10px;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .btn_select:hover {
    background    : #4da6aa !important;
    border-radius : 5px 30px !important;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .btn_select::after {
    display : none;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu {
    padding       : 10px;
    border-radius : 5px 30px;
    background    : #338c90;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu li .dropdown-item {
    padding     : 3px 0 0;
    font-style  : normal;

    font-size   : 16px;
    line-height : 22px;
    color       : #f6f6f7;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu li .dropdown-item:hover {
    background : transparent !important;
}

.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu:hover {
    background    : #4da6aa !important;
    border-radius : 5px 30px !important;
}

.home .header_bottom .header_bottom_left .setting_button {
    background    : #338c90;
    opacity       : 0.5;
    border-radius : 5px 30px;
    transition    : 0.5s;
    padding       : 10px 20px;
    border        : none;
}

.home .header_bottom .header_bottom_left .setting_button:hover {
    opacity : 1;
}

.home .header_bottom .header_bottom_right {
    display     : flex;
    align-items : center;
    gap         : 10px;
}

.home .header_bottom .header_bottom_right .right_button_bottom {
    background    : #338c90;
    opacity       : 0.5;
    border        : none;
    padding       : 10px 20px;
    transition    : 0.4s;
    border-radius : 5px 30px;
}

.home .header_bottom .header_bottom_right .right_button_bottom:hover {
    opacity : 1;
}

.home .header_bottom .header_bottom_right .right_button_bottom:first-child {
    opacity : 1;
}

.home table {
    width         : 100%;
    color         : white;
    padding       : 5px;
    border-radius : 10px;
}

.home table thead tr th {
    padding : 8px;
}

.home table tr td {
    padding : 8px;
}

</style>
