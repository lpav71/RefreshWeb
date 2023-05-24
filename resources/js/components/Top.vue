<template>
    <div class="account">
        <form action="finduser" method="get">
            <div class="left-user-account"><i class="fas fa-search fs-5 lupa"></i>
                <input type="text" name="searchUser" @input="searchClients" v-model="searchQuery" class="user-search" placeholder="Поиск пользователя">
            <div class="user-search-button" @click="addClient"><i class="fas fa-user-plus fs-3 icon-user-plus"></i></div>
            <div class="popup" v-show="findWindow" ref="findBlock">
                <ul>
                    <li v-for="(f, i) in filteredClients" @click="selectFindClient(i)">{{ f.login }}</li>
                </ul>
            </div>
        </div>
        <button ref="send" type="submit" style="display: none"></button>
        </form>
        <div class="right-user-account">
            <div class="user-search-button"><i class="fas fa-comment fs-3 icon-user-plus"></i></div>
            <div class="user-search-button" style="padding-left: 10px;"><i class="fas fa-bell fs-3 icon-user-plus"></i>
                <div class="notification"><span class="count-notif" style="color: var(--standart-color);font-size: 9px;">10</span></div>
            </div>
            <div class="user-select-button">
                <div class="avatar"><img style="width: 42px;height: 42px;" src="img/logo_test.jpg" alt=""></div>
                <select v-model="user_data" class="user-change" @change="promo">
                    <option value="name" selected="selected">{{ name }}</option>
                    <option value="promo">Промокоды</option>
                    <option value="dashboard">Статистика</option>
                    <option value="task">История задач</option>
                    <option value="infouser">Информация о пользователе</option>
                    <option value="tariffs">Тарифы и предложения</option>
                    <option value="pay_terminal">Настройки ККМ</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="regModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content reg">
                <div class="modal-header">
                    <h5 class="modal-title" id="regModalLabel">Регистрация нового пользователя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="main">
                        <div class="div_2">
                            <div class="div_login">
                                <div><input v-model="login" class="div_4" type="text" placeholder="Логин пользователя" /></div>
                                <div><input v-model="pass" class="div_4" type="text" placeholder="Пароль пользователя" /></div>
                            </div>
                            <div class="div_data">
                                <div class="div_3">
                                    <div><input v-model="firstName" class="div_4" type="text" placeholder="Фамилия" /><input v-model="lastName" class="div_4" type="text" placeholder="Имя" /><input v-model="patronymic" class="div_4" type="text" placeholder="Отчество" />
                                        <input v-model="bday" class="div_4" type="date" placeholder="Дата рождения" /></div>
                                </div>
                                <div class="div_3">
                                    <div><input v-model="phone" class="div_4" type="text" placeholder="Номер телефона" /><input v-model="address" class="div_4" type="text" placeholder="Адрес" /><input v-model="email" class="div_4" type="text" placeholder="E-Mail" /><input v-model="vkId" class="div_4" type="text" placeholder="VK ID" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="div_7">
                            <div class="bottom"><span class="span_1">Срок бездействия аккаунта до его удаления</span><select class="div_6">
                                <optgroup label="This is a group">
                                    <option value="12" selected>Выберите</option>
                                    <option value="13">This is item 2</option>
                                    <option value="14">This is item 3</option>
                                </optgroup>
                            </select></div>
                            <div class="bottom"><span class="span_1">Откуда клиент узнал о клубе? </span><select class="div_6">
                                <optgroup label="This is a group">
                                    <option value="12" selected>Выберите</option>
                                    <option value="13">This is item 2</option>
                                    <option value="14">This is item 3</option>
                                </optgroup>
                            </select></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="register">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['name', 'club_id'],
    data() {
        return {
            modal: null,
            login: null,
            pass: null,
            lastName: null,  //Фамилия
            firstName: null, //Имя
            patronymic: null, //Отчество
            bday: null,
            phone: null,
            address: null,
            email: null,
            vkId: null,
            user_data: 'name',
            clients: [],
            filteredClients: [],
            searchQuery: '',
            findWindow: false
        }
    },
    methods: {
        promo(e) {
            if (this.user_data == 'promo') {
                window.open("promo", '_self');
            }
            if (this.user_data == 'dashboard') {
                window.open("dashboard", '_self');
            }
            if (this.user_data == 'task') {
                window.open("task", '_self');
            }
            if (this.user_data == 'infouser') {
                window.open("userinfo", '_self');
            }
            if (this.user_data == 'tariffs') {
                window.open("tariffs", '_self');
            }
            if (this.user_data == 'pay_terminal') {
                window.open("pay_terminal", '_self');
            }
        },
        selectFindClient(i) {
            this.searchQuery = this.filteredClients[i].login;
            setTimeout(function (){
                this.$refs.send.click();
            }.bind(this),200);
        },
        addClient() {
            this.login = null;
            this.pass = null;
            this.lastName = null;
            this.firstName = null;
            this.patronymic = null;
            this.bday = null;
            this.phone = null;
            this.address = null;
            this.email = null;
            this.vkId = null;
            this.modal.show();
        },
        async register() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("login", this.login);
            urlencoded.append("pass", this.pass);
            urlencoded.append("lastName", this.lastName);
            urlencoded.append("firstName", this.firstName);
            urlencoded.append("patronymic", this.patronymic);
            urlencoded.append("bday", this.bday);
            urlencoded.append("phone", this.phone);
            urlencoded.append("address", this.address);
            urlencoded.append("email", this.email);
            urlencoded.append("vkId", this.vkId);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/client/register", requestOptions);
            var result = await response.text();
            if(result == 200) {
                this.modal.hide();
            }
            else {
                alert('!!! Ошибка записи !!!');
            }
        },
        async getClients() {
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

            var response = await fetch("api/client/all", requestOptions);
            this.clients = await response.json();
        },
        searchClients() {
            this.filteredClients = this.clients.filter(client => {
                this.findWindow = this.filteredClients.length > 1;
                if (this.searchQuery.length < 2) this.findWindow = false;
                return client.login.toLowerCase().includes(this.searchQuery.toLowerCase())
            });

        },
        handleClickOutside(event) {
            if (!this.$refs.findBlock.contains(event.target)) {
                this.findWindow = false
            }
        }
    },
    mounted() {
        var regModal = document.getElementById('regModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(regModal);
        this.getClients();
        document.addEventListener('click', this.handleClickOutside)
    },
    beforeUnmount() {
        document.removeEventListener('click', this.handleClickOutside)
    }
}
</script>

<style scoped>
.modal-body {
    padding: 0;
}
.modal-footer {
    justify-content: flex-start;
}
ul li {
    list-style-type: none;
    cursor: pointer;
}
.popup {
    width: 376px;
    background: var(--light-blue-bg-color);
    position: absolute;
    top: 80px;
    left: 12px;
    border-radius: 10px;
}
.reg {
    background: var(--dark-green-b);
    color: var(--standart-gray);
}
.main {
    width: 500px;
    height: 546px;
}

.div_1 {
    height: 74px;
    display: flex;
    flex-direction: column;
}

.div_2 {
    height: 353px;
    display: flex;
    color: var(--standart-gray);
    border-bottom-width: 1px;
    border-bottom-style: solid;
    border-color: #172d39;
    flex-direction: column;
}

.div_3 {
    width: 499px;
    height: 273px;
    display: flex;
    padding: 31px;
    padding-top: 0;
}

.div_7 {
    width: 257px;
    height: 183px;
    display: flex;
    padding: 31px;
    padding-top: 0;
    flex-direction: column;
}

.input_1 {
    background: #172D39;
    border: none;
    padding: 5px;
}

.div_4 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 23px;
    color: var(--standart-gray);
    border: none;
    padding-top: 2px;
    width: 190px;
    border-radius: 8px;
}

.div_6 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 6px;
    color: var(--standart-gray);
    border: none;
    padding-top: 2px;
    width: 190px;
    border-radius: 8px;
}

.div_5 {
    width: 300px;
    padding: 12px;
    height: 191px;
    display: flex;
    flex-direction: column;
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

.span_1 {
    margin-top: 14px;
    display: inline-block;
    font-size: 11px;
    color: var(--standart-gray);
}

.text_1 {
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 1px;
    color: var(--standart-gray);
    border: none;
    padding-top: 0px;
    width: 190px;
    border-radius: 8px;
}

.div_login {
    width: 500px;
    display: flex;
    justify-content: space-around;
    border-bottom: 1px solid #172d39;
    padding-bottom: 21px;
}

.div_data {
    display: flex;
}

.bottom {
    height: 92px;
}

.btn {
}

.bt {
    background: var(--light-green);
}
.account {
    position: relative;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    padding: 20px 0px;
    width: 1820px;
    height: 94px;
    top: 1px;
    justify-content: space-between;
    padding-right: 15px;
}
.user-search {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 10px 20px;
    gap: 10px;
    width: 376px;
    height: 54px;
    background: linear-gradient(180deg, #284F62 0%, #183F52 100%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    flex: none;
    order: 0;
    flex-grow: 0;
    border: none;
    color: var(--standart-color);
    padding-left: 50px;
    margin-left: -6px;
}
.left-user-account {
    display: flex;
    color: var(--standart-gray);
}
.lupa {
    position: relative;
    left: 30px;
    top: 19px;
    opacity: 0.5;
}
.user-search-button {
    height: 54px;
    width: 52px;
    background: var(--light-blue-bg-color);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    margin-left: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
.right-user-account {
    display: flex;
}
.icon-user-plus {
    opacity: 0.5;
    color: var(--standart-gray);
}
.user-select-button {
    width: 263px;
    height: 54px;
    background: var(--light-blue-bg-color);
    border-radius: 10px;
    margin-left: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.avatar {
    border-radius: 10px;
    overflow: hidden;
    margin-left: 10px;
}
.user-change {
    background: var(--light-blue-bg-color);
    width: 190px;
    color: var(--standart-gray);
    margin-right: 10px;
    border: none;
    height: 54px;
}
.user-change option {
    color: var(--standart-gray);
    background-color: #122834;
}
.notification {
    width: 15px;
    height: 15px;
    background: var(--light-green);
    border-radius: 11px;
    position: relative;
    left: -9px;
    top: -11px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
