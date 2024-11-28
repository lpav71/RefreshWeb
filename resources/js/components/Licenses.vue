<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left">
                <div class="contact_link">
                    <img alt="" src="/images/head_bottom/contact.svg"/>
                    Лицензии
                </div>
            </div>
            <div class="header_bottom_right">
                <button class="btn btn-success" @click="addCategory">Добавить категорию</button>
            </div>
        </div>
        <table class="table t1 table-borderless" style="margin-top: 20px;">
            <thead>
            <tr>
                <th style="width: 16.6%">Название категорий</th>
                <th style="width: 16.6%">Программа запуска</th>
                <th style="width: 16.6%">Групы ПК</th>
                <th style="width: 16.6%">Группы пользователей</th>
                <th style="width: 16.6%">Количество лицензий</th>
                <th style="width: 16.6%">Свободно лицензий</th>
            </tr>
            </thead>
        </table>
        <div class="fon">
            <table class="table t2 table-borderless" style="margin-top: 20px;">
                <tbody>
                <tr v-for="l in licenses">
                    <td style="width: 16.6%">{{ l.game }}</td>
                    <td style="width: 16.6%"></td>
                    <td style="width: 16.6%"></td>
                    <td style="width: 16.6%"></td>
                    <td style="width: 16.6%">{{ l.account }}</td>
                    <td style="width: 16.6%"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="addCategoryModal" aria-hidden="true" aria-labelledby="addCategoryModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addCategoryModalLabel" class="modal-title">Добавление steam аккаунта</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="block" style="margin-top: 0">
                        <span>Категория</span>
                        <input v-model="category" class="input" placeholder="Введите наименование категории" type="text"/>
                    </div>
                    <div class="block">
                        <span>Steam_ID</span>
                        <input v-model="steam_id" class="input" placeholder="Введите steam аккаунт" type="text"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="categorySave">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>
</template>

<script>

export default {
    props: ['club_id', 'user_id'],
    data() {
        return {
            permissions: {},
            licenses   : [],
            modal      : null,
            category   : '',
            steam_id   : ''
        }
    },
    methods: {
        addCategory() {
            this.category = '';
            this.steam_id = '';
            this.modal.show();
        },
        async categorySave() {
            this.modal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("category", this.category);
            urlencoded.append("steam_id", this.steam_id);
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/category/save", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }
            this.getLicenses();
        },
        async getPermissions() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("user_id", this.$props.user_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/getpermissions", requestOptions);
            if (response.ok) {
                this.permissions = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getLicenses() {
            var requestOptions = {
                method  : 'POST',
                redirect: 'follow'
            };

            var response = await fetch("api/licenses", requestOptions);
            if (response.ok) {
                this.licenses = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var addCategoryModal = document.getElementById('addCategoryModal')
        this.modal           = bootstrap.Modal.getOrCreateInstance(addCategoryModal);

        this.getPermissions();
        this.getLicenses();
    }
}
</script>

<style scoped>

.t2 {
    margin-top    : 13px;
    border-radius : 15px;
    overflow      : hidden;
}

.t1 th:not(:last-child) {
    border-color       : #4d4d4d;
    border-right-width : 1px;
    border-right-style : solid;
}

.t2 td:not(:last-child) {
    padding    : 10px;
    text-align : center;
}

.t1 {
    border-radius : 15px;
    overflow      : hidden;
    padding       : 10px;
    text-align    : center;
    font-weight   : normal;
    margin-bottom : 20px;
    background    : var(--light-blue-bg-color);
    line-height   : 36px;
}

.fon {
    height        : 680px;
    background    : var(--light-blue-bg-color);
    border-radius : 10px;
}

.block {
    display        : flex;
    flex-direction : column;
    align-items    : flex-start;
    margin-top     : 12px;
}

.bt {
    background : var(--light-green);
}

.input {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 6px;
    color         : var(--standart-gray);
    border        : none;
    width         : 465px;
    border-radius : 8px;
}

.modal-body {
    padding : 15px;
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
    height      : 815px;
    margin-left : 13px;
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
    font-size     : 17px;
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
