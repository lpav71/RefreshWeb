<template>

    <div class="home">
        <div class="header">
            <div class="left">
                <div class="top"><img alt="" src="img/5.svg"/><span style="margin-left: 14px;">Сотрудники и роли</span></div>
            </div>
        </div>
        <div class="bottom">
            <div class="side">
                <button class="btn btn-success" type="button" @click="editModal">Добавить роль</button>
                <template v-for="p in positions">
                    <div class="div_4 span-1">
                        <span>{{ p.position_name }}</span>
                    </div>
                </template>

                <span style="margin-top: 23px;display: block;">Пригласить нового сотрудника</span><br>
                <label>Выберите роль
                    <select class="div_4 span-1" style="margin-top: 7px;">
                        <option>Администратор</option>
                    </select>
                </label>
                <input v-model="rate" class="div_4 span-1" placeholder="Сумма за выход" @input="numVerifyDoubleOut">
                <input v-model="rate_percent" class="div_4 span-1" placeholder="Процентная ставка" @input="numVerifyDoublePercent">
                <input v-model="work_experience" class="div_4 span-1" placeholder="Стаж работы" @input="numVerifyDoubleExperience">
                <input v-model="email" class="div_4 span-1" placeholder="E-mail">
                <button class="btn btn-success" style="margin-top: 30px;" @click="SendInvitation">Отправить приглашение</button>

            </div>
            <div class="side">
                <div class="users">
                    <div v-for="u in users" class="one_user">
                        <div class="foto"><img :src="u.icon" alt="" height="50" width="50"></div>
                        <div class="fio" @click="showPermissionsModal(u.id)">
                            <span>{{ u.name }}</span><br><span class="c_position">{{ u.position_name }}</span>
                        </div>
                        <div class="invitation">
                            <span>Приглашён</span><br><span class="c_position">Васей Пупкиным</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="permissionsModal" aria-hidden="true" aria-labelledby="permissionsModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="permissionsModalLabel" class="modal-title">Настройка роли</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <label><input v-model="new_user" class="check" type="checkbox">Создание нового пользователя</label><br>
                    <label><input v-model="balance_money" class="check" type="checkbox">Пополнение баланса деньгами</label><br>
                    <label><input v-model="balance_bonus" class="check" type="checkbox">Пополнение баланса бонусами</label><br>
                    <label><input v-model="ret_money" class="check" type="checkbox">Возврат деньги</label><br>
                    <label><input v-model="ret_bonus" class="check" type="checkbox">Возврат бонусы</label><br>
                    <label><input v-model="open_shift" class="check" type="checkbox">Открыть смену</label><br>
                    <label><input v-model="close_shift" class="check" type="checkbox">Закрыть смену</label><br>
                    <label><input v-model="create_pc" class="check" type="checkbox">Добавить ПК</label><br>
                    <label><input v-model="create_zone" class="check" type="checkbox">Добавить зону</label><br>
                    <label><input v-model="create_task" class="check" type="checkbox">Добавить задачу</label><br>
                    <label><input v-model="shop_pay" class="check" type="checkbox">Продажа из магазина</label><br>
                    <label><input v-model="create_promo" class="check" type="checkbox">Добавить промокод</label><br>
                    <label><input v-model="create_game" class="check" type="checkbox">Добавить игру</label><br>
                    <label><input v-model="del_game" class="check" type="checkbox">Удалить игру</label><br>
                    <label><input v-model="edit_game" class="check" type="checkbox">Редактировать игру</label><br>
                    <label><input v-model="create_steam_acc" class="check" type="checkbox">Добавить steam аккаунт</label><br>
                    <label><input v-model="price_create" class="check" type="checkbox">Добавить тариф</label><br>
                    <label><input v-model="price_del" class="check" type="checkbox">Удалить тариф</label><br>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="update">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>
    <system-message ref="sysMessage"></system-message>

</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id', 'user_id'],
    data() {
        return {
            users           : null,
            positions       : null,
            permissionsModal: null,
            new_user        : false,
            balance_money   : false,
            balance_bonus   : false,
            ret_money       : false,
            ret_bonus       : false,
            open_shift      : false,
            close_shift     : false,
            create_pc       : false,
            create_zone     : false,
            create_task     : false,
            shop_pay        : false,
            create_promo    : false,
            create_game     : false,
            del_game        : false,
            edit_game       : false,
            create_steam_acc: false,
            price_create    : false,
            price_del       : false,
            user_id         : 0,
            email           : '',
            rate            : '',
            rate_percent    : '',
            work_experience : ''
        }
    },
    methods: {
        numVerifyDoublePercent(e) {
            this.rate_percent = verifyNumDouble(e);
        },
        numVerifyDoubleExperience(e) {
            this.work_experience = verifyNumDouble(e);
        },
        numVerifyDoubleOut(e) {
            this.rate = verifyNumDouble(e);
        },
        async SendInvitation() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("email", this.email);
            urlencoded.append("rate", this.rate);
            urlencoded.append("rate_percent", this.rate_percent);
            urlencoded.append("work_experience", this.work_experience);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/send_invitation", requestOptions);
            if (response.ok) {
                this.$refs.sysMessage.text = 'Отправлено';
                this.$refs.sysMessage.modal.show();
                var data = {
                    "club_id"        : this.$props.club_id,
                    "email"          : this.email,
                    "rate"           : this.rate,
                    "rate_percent"   : this.rate_percent,
                    "work_experience": this.work_experience

                }
                createLog(JSON.stringify(data), 'Отправка приглашения новому пользователю', 'position', this.$props.user_id)
            }

        },
        showPermissionsModal(user_id) {
            this.permissionsModal.show();
            this.user_id = user_id;
            this.accesses(user_id);
        },
        async accesses(user_id) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("user_id", user_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/accesses", requestOptions);
            if (response.ok) {
                var result            = await response.json();
                this.new_user         = result.new_user;
                this.balance_money    = result.balance_money;
                this.balance_bonus    = result.balance_bonus;
                this.ret_money        = result.ret_money;
                this.ret_bonus        = result.ret_bonus;
                this.open_shift       = result.open_shift;
                this.close_shift      = result.close_shift;
                this.create_pc        = result.create_pc;
                this.create_zone      = result.create_zone;
                this.create_task      = result.create_task;
                this.shop_pay         = result.shop_pay;
                this.create_promo     = result.create_promo;
                this.create_game      = result.create_game;
                this.del_game         = result.del_game;
                this.edit_game        = result.edit_game;
                this.create_steam_acc = result.create_steam_acc;
                this.price_create     = result.price_create;
                this.price_del        = result.price_del;
            } else {
                this.$refs.message.modal.show();
            }
        },
        async update() {
            this.permissionsModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("user_id", this.user_id);
            urlencoded.append("new_user", this.new_user);
            urlencoded.append("balance_money", this.balance_money);
            urlencoded.append("balance_bonus", this.balance_bonus);
            urlencoded.append("ret_money", this.ret_money);
            urlencoded.append("ret_bonus", this.ret_bonus);
            urlencoded.append("open_shift", this.open_shift);
            urlencoded.append("close_shift", this.close_shift);
            urlencoded.append("create_pc", this.create_pc);
            urlencoded.append("create_zone", this.create_zone);
            urlencoded.append("create_task", this.create_task);
            urlencoded.append("shop_pay", this.shop_pay);
            urlencoded.append("create_promo", this.create_promo);
            urlencoded.append("create_game", this.create_game);
            urlencoded.append("del_game", this.del_game);
            urlencoded.append("edit_game", this.edit_game);
            urlencoded.append("create_steam_acc", this.create_steam_acc);
            urlencoded.append("price_create", this.price_create);
            urlencoded.append("price_del", this.price_del);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/access/update", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }
        },
        async getUsers() {
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

            var response = await fetch("api/position/getuser", requestOptions);
            if (response.ok) {
                this.users = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getPositions() {
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

            var response = await fetch("api/position/get", requestOptions);
            if (response.ok) {
                this.positions = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var permissionsModal  = document.getElementById('permissionsModal')
        this.permissionsModal = bootstrap.Modal.getOrCreateInstance(permissionsModal);

        this.getUsers();
        this.getPositions();
    }
}
</script>

<style scoped>
.modal-body {
    padding : 15px;
}

.check {
    margin-right : 10px;
}

.c_position {
    color : var(--dark-green-b);
}

.foto {
    border-radius : 10px;
    overflow      : hidden;
}

.fio {
    width   : 210px;
    padding : 0 5px 0 10px;
    cursor  : pointer;
}

.invitation {
    width   : 210px;
    padding : 0 5px 0 10px;
}

.one_user {
    display       : flex;
    padding       : 8px;
    border-bottom : #034046 1px solid;
}

.users {
    width         : 487px;
    height        : 506px;
    background    : var(--standart-black);
    border-radius : 20px;
    position      : relative;
    left          : 500px;
    padding       : 20px;
    overflow      : auto;
}

.side {
    display : inline-block;
}

.span-1 {
    margin-top : 14px;
    display    : block;
    font-size  : inherit;
}

.div_4 {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 20px;
    color         : var(--standart-gray);
    border        : none;
    width         : 190px;
    border-radius : 8px;
    font-size     : inherit;
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

.home .header {
    width           : 516px;
    display         : flex;
    justify-content : start;
}

.bottom {
    width         : 1793px;
    height        : 762px;
    background    : var(--light-blue-bg-color);
    margin-top    : 10px;
    border-radius : 20px;
    padding       : 20px;
    display       : flex;
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
    display       : inline-block;
}

.butt1 {
    background    : var(--disable);
    border        : none;
    height        : 42px;
    margin-top    : 20px;
    min-width     : 94px;
    padding-right : 20px;
    padding-left  : 20px;
    display       : inline-block;
    border-radius : 5px;
}

.top {
    width   : 235px;
    height  : 42px;
    display : inline-block;
}
</style>
