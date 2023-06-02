<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left">
                <div class="contact_link">
                    <img src="/images/head_bottom/contact.svg" alt=""/>
                    Пользователи
                </div>
                <img src="/images/head_bottom/search.svg" alt=""/>
                <input type="text" class="search-user" v-model="searchUser" @keydown="enter" placeholder="Поиск"/>
                <div class="btn-group btn_select_wrapper">
                    <button type="button" class="btn btn-danger btn_select dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Возраст
                        <img src="/images/header/arrov.svg" alt=""/>
                    </button>
                    <ul class="dropdown-menu dropdown_menu">
                        <li>
                            <div class="dropdown-item">Action</div>
                        </li>
                        <li>
                            <div class="dropdown-item">Another action</div>
                        </li>
                        <li>
                            <div class="dropdown-item">Something else here</div>
                        </li>
                    </ul>
                </div>
                <div class="btn-group btn_select_wrapper">
                    <button type="button" class="btn btn-danger btn_select dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Дата регистрации <img src="/images/header/arrov.svg" alt=""/>
                    </button>
                    <ul class="dropdown-menu dropdown_menu">
                        <li>
                            <div class="dropdown-item">Action</div>
                        </li>
                        <li>
                            <div class="dropdown-item">Another action</div>
                        </li>
                        <li>
                            <div class="dropdown-item">Something else here</div>
                        </li>
                    </ul>
                </div>
                <button class="setting_button">
                    <img src="/images/head_bottom/setting.svg" alt=""/>
                </button>
            </div>
            <div class="header_bottom_right">
                <button class="right_button_bottom"><img src="/images/head_bottom/plus.svg" alt=""/></button>
                <button class="right_button_bottom"><img src="/images/head_bottom/arrov.svg" alt=""/></button>
                <button class="right_button_bottom"><img src="/images/head_bottom/arrov_top.svg" alt=""/></button>
            </div>
        </div>
        <div class="fon">
            <table class="table table-borderless" style="margin-top: 20px;">
                <thead>
                <tr>
                    <th>Логин</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Почта</th>
                    <th>Основной баланс</th>
                    <th>Бонусный баланс</th>
                    <th>Скидочная группа</th>
                    <th>Статус аккаунта</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(user, index) in findUsers">
                    <td>{{ user.login }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.surname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.amount }}</td>
                    <td>{{ user.bonus }}</td>
                    <td>500</td>
                    <td>хороший</td>
                    <td>
                        <button class="btn btn-sm topBalance" @click="topBalance(index, user.login)">Пополнить баланс</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="topBalanceModal" tabindex="-1" aria-labelledby="topBalanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topBalanceModalLabel" style="color: white">Пополнение баланса пользователя <span style="color: #0d6efd">{{ login }}</span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body" style="padding-left: 15px;">

                    <div class="main">
                        <div class="div_1"><span>Сумма</span><input class="input_1 rounded" v-model.number="summa" type="number" maxlength="10" /></div>
                        <div class="div_2">
                            <div class="div_3"><span>Способы оплаты</span>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start"><input id="formCheck-1" class="form-check-input check-1" type="radio" name="payment" v-model="pay" value="cash" style="opacity: 0;position: absolute;z-index: -1;" /><label class="form-check-label label-1" for="formCheck-1">Наличные</label></div>
                                </div>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start"><input id="formCheck-3" class="form-check-input check-1" type="radio" name="payment" v-model="pay" value="card" style="opacity: 0;position: absolute;z-index: -1;" /><label class="form-check-label label-1" for="formCheck-3">Карта</label></div>
                                </div>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start"><input id="formCheck-2" class="form-check-input check-1" type="radio" name="payment" v-model="pay" value="bonus" style="opacity: 0;position: absolute;z-index: -1;" /><label class="form-check-label label-1" for="formCheck-2">Бонусная валюта</label></div>
                                </div>
                            </div>
                            <div class="div_3"><span>Чек</span>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start"><input id="formCheck-4" class="form-check-input check-2" type="radio" name="chek" v-model="chek" value="post" style="opacity: 0;position: absolute;z-index: -1;" /><label class="form-check-label label-1" for="formCheck-4">Отправить на почту</label></div>
                                </div>
                                <div class="div_4">
                                    <div class="form-check form-check-reverse text-start"><input id="formCheck-5" class="form-check-input check-2" type="radio" name="chek" v-model="chek" value="print" style="opacity: 0;position: absolute;z-index: -1;" /><label class="form-check-label label-1" for="formCheck-5">Печатать</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="div_1">
                            <div class="div_1"><span>Комментарий к платежу</span><input class="input_1 rounded" type="text" v-model="comment" /></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn pay" :disabled="payTextDisabled" @click="payment">{{ payText }}</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['club_id', 'f_user'],
    data() {
        return {
            payText: 'Оплата',
            payTextDisabled: false, //Кнопка доступна
            messages: [],
            searchUser: "",
            findUsers: [],
            modal: {},
            login: "",
            pay: '',
            chek: '',
            currentUser: {},
            summa: 0,
            comment: '',
            timer: null
        }
    },
    methods: {
        enter(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        payment() {
            var outData = {
                data: {
                    "userid": this.currentUser.id,
                    "paytype": this.pay,
                    "check": this.chek,
                    "comment": this.comment
                },
                "prodlist": [{
                    "amount": this.summa,
                    "product": "Пополнение счёта",
                    "quantity": 1
                }]
            };
            console.log(JSON.stringify(outData));
            this.messages = [];
/*
            this.payText = 'Ждите';
            this.payTextDisabled = true;
            this.timer = setInterval(this.listenMessage, 1000);
*/
        },
        listenMessage() {
            if (this.messages[0] !== undefined) {
                var ms = JSON.parse(this.messages[0]);
                if (ms.message.id == this.$props.club_id && ms.message.operation === 'close') {
                    this.modal.hide();
                    this.payText = 'Оплата';
                    this.payTextDisabled = false;
                    clearInterval(this.timer);
                }
                this.messages = [];
            }
        },
        async topBalance(i, login) {
            this.login = login;
            this.currentUser = this.findUsers[i];
            this.summa = 0;
            this.comment = "";
            this.pay = '';
            this.chek = '';

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.findUsers[i].club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/findopenshift", requestOptions);
            var result = await response.json();
            var forConsole = JSON.stringify(result);
            console.log(forConsole);
            var statusShift = result.shiftStatus;
            //statusShift = 'open';
            if (statusShift === 'open') {
                this.modal.show();
            }
            else {
                alert ('Нет открытой смены');
            }
        },
        search() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");
            var urlencoded = new URLSearchParams();
            urlencoded.append("user", this.searchUser);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            fetch("api/findusers", requestOptions)
                .then(response => response.json())
                .then(result => {
                    this.findUsers = result;
                })
                .catch(error => console.log('error', error));
        }
    },
    mounted() {
        // PUSHER ---------------------------------------------
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('6a5d1d953f639e0236dc', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            this.messages.push(JSON.stringify(data));
        }.bind(this));
        // ~PUSHER ---------------------------------------------
        if (this.$props.f_user != "") {
            this.findUsers = JSON.parse(this.$props.f_user);
        }
        var topBalanceModal = document.getElementById('topBalanceModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(topBalanceModal);
        console.log(this.modal);
    }
}
</script>

<style scoped>

.main {
    width: 470px;
    height: 350px;
    background: var(--light-blue-bg-color);
    color: white;
}
.fon {
    height: 885px;
    background: var(--light-blue-bg-color);
    border-radius: 10px;
}
.pay {
  background: var(--light-green);
}

.topBalance {
    background: var(--light-green);
    font-size: 15px;
}

.div_1 {
    height: 74px;
    display: flex;
    flex-direction: column;
}

.div_2 {
    height: 200px;
    display: flex;
}

.div_3 {
    width: 49.5%;
    height: 100%;
    display: inline-block;
    padding: 12px;
}

.input_1 {
    background: #172D39;
    border: none;
    padding: 5px;
    margin-top: 5px;
    color: white;
}

.div_4 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    border-bottom-left-radius: 27px;
    border-top-right-radius: 27px;
    border-top-left-radius: 5px;
    border-bottom-right-radius: 5px;
    margin-top: 10px;
}

.check-1 + label {
    display: inline-flex;
    align-items: center;
    user-select: none;
}

.check-1 + label::after {
    content: '';
    display: inline-block;
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #adb5bd;
    border-radius: 0.25em;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
    left: 186px;
    position: absolute;
}

.check-1:checked + label::after {
    border-color: #0b76ef;
    background-color: #0b76ef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.label-1 {
    font-size: 15px;
    width: 500px;
}

.check-2 + label {
    display: inline-flex;
    align-items: center;
    user-select: none;
}

.check-2 + label::after {
    content: '';
    display: inline-block;
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #adb5bd;
    border-radius: 0.25em;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
    left: 416px;
    position: absolute;
}

.check-2:checked + label::after {
    border-color: #0b76ef;
    background-color: #0b76ef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

/* ------------------------------------------- */
.menu_bottom svg {
    margin-top: 20px;
}
nav {
    display: flex;
}
nav{
    width: 100%;
    padding: 0 20px;
}
.search-user {
    background: #162c38;
    color: #f6f6f7;
    padding: 8px;
    border: none;
}
.header_top .head_left .head_search button {
    border: none;
    background: transparent;
    outline: none;
}
.header_top .head_left .head_search button img {
    max-width: 16px;
}
.header_top .head_left .head_search input {
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    margin-left: 10px;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 22px;
    color: #c6c6c6;
}
.header_top .head_left .head_search input::placeholder {
    opacity: 0.5;
}
.head_contact span {
    background: var(--light-green);
    width: 23px;
    height: 23px;
    border-radius: 10px;
    display: block;
    position: relative;
    left: 17px;
    top: -40px;
}

.header_top .head_right .head_link img {
    max-width: 32px;
}
.header_top .head_right .head_link span {
    position: absolute;
    background: #61babe;
    border-radius: 100px;
    width: 15px;
    height: 15px;
    font-family: "Montserrat", sans-serif;
    font-style: normal;
    font-weight: 700;
    font-size: 8px;
    line-height: 22px;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 13px;
    right: 12px;
}
.header_top .head_right .head_ava .head_ava_title h2 {
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 22px;
    color: #f6f6f7;
    margin-bottom: 0;
}
.header_top .head_right .head_ava .head_ava_title p {
    margin-bottom: 0;
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 22px;
    color: #c6c6c6;
}
.header_top .head_right .dropdown-menu .dropdown-item {
    display: flex;
}
.header_top .head_right .dropdown-menu .dropdown-item:hover {
    background: var(--table-bg);
}
.header_top .head_right .dropdown-menu .dropdown-item img {
    height: 35px;
}
.header_top .head_right .dropdown-menu .dropdown-item {
    margin-left: 0;
}
.header_top .head_right .dropdown-menu .dropdown-item .head_ava_title h2 {
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 18px;
    color: #f6f6f7;
    margin-bottom: 0;
}
.header_top .head_right .dropdown-menu .dropdown-item .head_ava_title p {
    margin-bottom: 0;
    font-style: normal;
    font-weight: 400;
    font-size: 10px;
    line-height: 18px;
    color: #c6c6c6;
}
.home {
    margin-top: 20px;
    width: 1793px;
    margin-left: 13px;
}
.home .header_bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.home .header_bottom .header_bottom_left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.home .header_bottom .header_bottom_left .contact_link {
    display: flex;
    align-items: center;
    font-family: "Russia", sans-serif;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 22px;
    color: #f6f6f7;
    text-decoration: none;
    padding: 10px;
}
.home .header_bottom .header_bottom_left .contact_link img {
    margin-right: 10px;
}
.home .header_bottom .header_bottom_left .search_bottom {
    background: #122733;
    border-radius: 5px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.home .header_bottom .header_bottom_left .search_bottom input {
    background: transparent;
    border: none;
    outline: none;
    font-family: "Russia",serif;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 22px;
    color: #c6c6c6;
}
.home .header_bottom .header_bottom_left .search_bottom input::placeholder {
    opacity: 0.5;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .btn_select {
    padding: 10px 20px;
    background: #338c90;
    border-radius: 5px 30px;
    border: none;
    font-family: "Russia", sans-serif;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 22px;
    color: #f6f6f7;
    transition: 0.4s;
    display: flex;
    align-items: center;
    gap: 10px;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .btn_select:hover {
    background: #4da6aa !important;
    border-radius: 5px 30px !important;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .btn_select::after {
    display: none;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu {
    padding: 10px;
    border-radius: 5px 30px;
    background: #338c90;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu li .dropdown-item {
    padding: 3px 0 0;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 22px;
    color: #f6f6f7;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu li .dropdown-item:hover {
    background: transparent !important;
}
.home .header_bottom .header_bottom_left .btn_select_wrapper .dropdown_menu:hover {
    background: #4da6aa !important;
    border-radius: 5px 30px !important;
}
.home .header_bottom .header_bottom_left .setting_button {
    background: #338c90;
    opacity: 0.5;
    border-radius: 5px 30px;
    transition: 0.5s;
    padding: 10px 20px;
    border: none;
}
.home .header_bottom .header_bottom_left .setting_button:hover {
    opacity: 1;
}
.home .header_bottom .header_bottom_right {
    display: flex;
    align-items: center;
    gap: 10px;
}
.home .header_bottom .header_bottom_right .right_button_bottom {
    background: #338c90;
    opacity: 0.5;
    border: none;
    padding: 10px 20px;
    transition: 0.4s;
    border-radius: 5px 30px;
}
.home .header_bottom .header_bottom_right .right_button_bottom:hover {
    opacity: 1;
}
.home .header_bottom .header_bottom_right .right_button_bottom:first-child {
    opacity: 1;
}
.home table{
    width: 100%;
    color: white;
    padding: 5px;
    font-size: 17px;
    border-radius: 10px;
}
.home table thead tr th {
    padding: 8px;
}
.home table tr td {
    padding: 8px;
}

</style>
