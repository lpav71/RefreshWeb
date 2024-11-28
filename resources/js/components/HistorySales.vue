<template>
    <div class="home">
        <a ref="csvfile" :href="filename" download="" style="display: none">{{ filename }}</a>
        <div class="header_bottom">
            <div class="header_bottom_left">
                <div class="contact_link">
                    <img alt="" src="/images/head_bottom/contact.svg"/>
                    История продаж
                </div>
                <img alt="" src="/images/head_bottom/search.svg"/>
                <input v-model="searchUser" class="search-user" placeholder="Логин пользователя" type="text" @keydown="enter"/>
                <img alt="" src="/images/head_bottom/search.svg"/>
                <input v-model="searchUser" class="search-user" placeholder="Логин сотрудника" type="text" @keydown="enter"/>
                <button class="btn btn-success" type="button">Выберите ПК</button>
                <button class="btn btn-success" type="button">Дата операции</button>
                <button class="btn btn-success" @click="generateReport"><img alt="" src="img/download-bold.svg" style="margin-bottom: 5px;"></button>
            </div>
            <div class="header_bottom_right">
                <button class="btn btn-success"><img alt="" src="/images/head_bottom/plus.svg"/></button>
            </div>
        </div>
        <table class="table table-borderless t1" style="margin-top: 20px;">
            <thead>
            <tr>
                <th style="width: 14.3%">Транзакция</th>
                <th style="width: 14.3%">Пользователь</th>
                <th style="width: 14.3%">Администратор</th>
                <th style="width: 14.3%">Дата\Время</th>
                <th style="width: 14.3%">Сумма</th>
                <th style="width: 14.3%">Тип операции</th>
                <th style="width: 14.3%">Смена</th>
            </tr>
            </thead>
        </table>
        <div class="fon">
            <table class="table table-borderless t2">
                <tbody>
                <tr v-for="(d, index) in sales">
                    <td style="width: 14.3%; cursor: pointer" @click="getSale(index)">{{ d.id }}</td>
                    <td style="width: 14.3%">{{ d.login }}</td>
                    <td style="width: 14.3%">{{ d.name }}</td>
                    <td style="width: 14.3%">{{ d.time }}</td>
                    <td style="width: 14.3%">{{ d.amount }}</td>
                    <td style="width: 14.3%">{{ d.bar }}</td>
                    <td style="width: 14.3%">{{ d.shift }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="saleModal" aria-hidden="true" aria-labelledby="saleModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="saleModalLabel" class="modal-title">Продажа</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Количество</th>
                            <th>Цена</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="s in sale">
                            <td>{{ s.product }}</td>
                            <td>{{ s.num }}</td>
                            <td>{{ s.price }}</td>
                            <td>{{ s.total }}</td>
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
            sales    : [],
            sale     : {},
            modalSale: null,
            filename : ''
        }
    },
    methods: {
        async generateReport() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");
            var raw = JSON.stringify({
                "collection": this.sales,
                "header"    : "Транзакция, Администратор, Пользователь, Дата\\Время, Сумма, Тип операции, Смена"
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
        async getSales() {
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

            var response = await fetch("api/sales", requestOptions);
            if (response.ok) {
                this.sales = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getSale(index) {
            var id        = this.sales[index].id;
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

            var response = await fetch("api/sale", requestOptions);
            if (response.ok) {
                this.sale = await response.json();
                this.modalSale.show();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var saleModal  = document.getElementById('saleModal')
        this.modalSale = bootstrap.Modal.getOrCreateInstance(saleModal);

        this.getSales();
    }
}
</script>

<style lang="scss" scoped>

$paddingTable : 10px;

.modal-header ~ h5 {
    display : inline-block;
}

.modal-body {
    table {
        color : var(--standart-gray);
    }
}

.regular {
    background : var(--regular);
}

.t1 {
    margin-bottom : 20px;
    background    : var(--light-blue-bg-color);
    line-height   : 36px;
}

.reservation-table {
    width : 100%;

    thead {
        tr {
            th {
                padding       : $paddingTable;
                border-bottom : 1px solid white;
            }
        }
    }

    tbody {
        tr {
            td {
                padding : $paddingTable;
            }

            border-bottom : 1px solid white;
        }
    }
}

.bt {
    margin-right : 10px;
}

.modal-body {
    padding : 15px;
}

.main {
    width      : 470px;
    height     : 350px;
    background : var(--light-blue-bg-color);
    color      : white;
}

.fon {
    height        : 680px;
    background    : var(--light-blue-bg-color);
    border-radius : 10px;
}

.pay {
    background : var(--light-green);
}

.topBalance {
    background   : var(--light-green);
    font-size    : 15px;
    margin-right : 10px;
}

.text-block {
    height         : 407px;
    display        : flex;
    flex-direction : column;
}

.div_1 {
    height         : 74px;
    display        : flex;
    flex-direction : column;
}

.div_2 {
    height  : 200px;
    display : flex;
}

.div_3 {
    width   : 49.5%;
    height  : 100%;
    display : inline-block;
    padding : 12px;
}

.input_1 {
    background : #172d39;
    border     : none;
    padding    : 5px;
    margin-top : 5px;
    color      : white;
}

.div_4 {
    height                     : 35px;
    background                 : #172d39;
    padding                    : 5px 15px 5px 15px;
    border-bottom-left-radius  : 27px;
    border-top-right-radius    : 27px;
    border-top-left-radius     : 5px;
    border-bottom-right-radius : 5px;
    margin-top                 : 10px;
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
    border-radius       : 0.25em;
    margin-right        : 0.5em;
    background-repeat   : no-repeat;
    background-position : center center;
    background-size     : 50% 50%;
    left                : 186px;
    position            : absolute;
}

.check-1:checked + label::after {
    border-color     : #0b76ef;
    background-color : #0b76ef;
    background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.label-1 {
    font-size : 15px;
    width     : 500px;
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
    display         : flex;
    justify-content : space-between;
    align-items     : center;
}

.home .header_bottom .header_bottom_left {
    display     : flex;
    align-items : center;
    gap         : 10px;
}

.home .header_bottom .header_bottom_left .contact_link {
    display         : flex;
    align-items     : center;
    font-style      : normal;

    font-size       : 16px;
    line-height     : 22px;
    color           : #f6f6f7;
    text-decoration : none;
    padding         : 10px;
}

.home .header_bottom .header_bottom_left .contact_link img {
    margin-right : 10px;
}

.home .header_bottom .header_bottom_left .search_bottom {
    background    : #122733;
    border-radius : 5px;
    padding       : 10px;
    display       : flex;
    align-items   : center;
    gap           : 10px;
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

.btn_select {
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
    padding     : 8px;
    font-weight : normal;
}

.home table tr td {
    padding : 8px;
}

</style>
