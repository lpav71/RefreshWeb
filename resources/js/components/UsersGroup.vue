<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left">
                <div class="contact_link">
                    <img alt="" src="/images/head_bottom/contact.svg"/>
                    Группы пользователей
                </div>
            </div>
            <div class="header_bottom_right">
                <button class="btn btn-success" @click="addGroupModaShow">Добавить группу +</button>
            </div>
        </div>
        <table class="table table-borderless t1" style="margin-top: 20px;">
            <thead>
            <tr>
                <th style="width: 20%">Название группы</th>
                <th style="width: 20%">Скидка</th>
                <th style="width: 20%">Категории товаров/услуг</th>
                <th style="width: 25%">Порог для вступления в группу</th>
                <th>Откат прогресса</th>
            </tr>
            </thead>
        </table>
        <div class="fon">
            <table class="table table-borderless t2" style="cursor: pointer">
                <tbody>
                <tr v-for="(g, index) in groups" @contextmenu.prevent="contextMenuShow($event, index)">
                    <td style="width: 20%">{{ g.name }}</td>
                    <td style="width: 20%">{{ g.discount }}</td>
                    <td style="width: 20%">{{ g.category }}</td>
                    <td style="width: 25%">{{ g.amount }} рублей</td>
                    <td>{{ g.progress_return }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно Добавить группу -->
    <div id="addGroupModal" aria-hidden="true" aria-labelledby="addGroupModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addGroupModalLabel" class="modal-title">Добавить группу</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="div_1"><span>Название группы</span><input v-model="name" class="input_1 rounded" type="text"/></div>
                    <div class="div_1"><span>Скидка</span><input v-model="discount" class="input_1 rounded" type="text"/></div>
                    <div class="div_1"><span>Категории товаров/услуг</span>
                        <select v-model="category" class="input_1 rounded">
                            <option value="all">Все</option>
                            <option value="goods">Товары</option>
                            <option value="services">Услуги</option>
                            <option value="not">Нет</option>
                        </select>
                    </div>
                    <div class="div_1">
                        <span>Порог для вступления в группу</span><input v-model="amount" class="input_1 rounded" maxlength="10" type="text"/></div>
                    <div class="div_1">
                        <span>Откат прогресса (дней)</span><input v-model="progress_return" class="input_1 rounded" maxlength="10" type="text"/></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="addGroup">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Редактировать группу -->
    <div id="editGroupModal" aria-hidden="true" aria-labelledby="editGroupModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="editGroupModalLabel" class="modal-title">Редактировать группу</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="div_1"><span>Название группы</span><input v-model="name" class="input_1 rounded" type="text"/></div>
                    <div class="div_1"><span>Скидка</span><input v-model="discount" class="input_1 rounded" type="text"/></div>
                    <div class="div_1">
                        <span>Порог для вступления в группу</span><input v-model="amount" class="input_1 rounded" maxlength="10" type="text"/></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="editGroupSave">Сохранить</button>
                </div>
            </div>
        </div>
    </div>


    <message ref="message"></message>
    <context-menu-new ref="context" @onItemSelected="itemSelected"></context-menu-new>

</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id', 'user_id'],
    data() {
        return {
            groups         : [],
            modal          : null,
            name           : '',
            discount       : '',
            category       : '',
            amount         : '',
            id             : '',
            progress_return: '',
            editGroupModal : null
        }
    },
    methods: {
        async editGroupSave() {
            this.editGroupModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("name", this.name);
            urlencoded.append("id", this.id);
            urlencoded.append("discount", this.discount);
            urlencoded.append("amount", this.amount);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user_group/edit", requestOptions);
            if (response.ok) {
                this.getGroups();
            } else {
                this.$refs.message.modal.show();
            }
        },
        itemSelected(item) {
            switch (item) {
                case 'Редактировать':
                    this.edit();
                    break;
                case 'Удалить':
                    this.delete();
                    break;
            }
        },
        contextMenuShow(e, i) {
            this.$refs.context.contextMenuShow = true;
            this.$refs.context.contextMenuTop  = e.pageY;
            this.$refs.context.contextMenuLeft = e.pageX;
            this.name                          = this.groups[i].name;
            this.discount                      = this.groups[i].discount;
            this.amount                        = this.groups[i].amount;
            this.id                            = this.groups[i].id;
            this.$refs.context.show();
        },
        edit() {
            this.editGroupModal.show();
        },
        async delete() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", this.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user_group/delete", requestOptions);
            if (response.ok) {
                this.getGroups();
            } else {
                this.$refs.message.modal.show();
            }
        },
        addGroupModaShow() {
            this.name            = '';
            this.discount        = '';
            this.category        = '';
            this.amount          = '';
            this.progress_return = '';
            this.modal.show();
        },
        async addGroup() {
            this.modal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("name", this.name);
            urlencoded.append("discount", this.discount);
            urlencoded.append("category", this.category);
            urlencoded.append("amount", this.amount);
            urlencoded.append("progress_return", this.progress_return);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user_group/add", requestOptions);
            if (response.ok) {
                var data = {
                    "club_id"        : this.$props.club_id,
                    "name"           : this.name,
                    "discount"       : this.discount,
                    "category"       : this.category,
                    "amount"         : this.amount,
                    "progress_return": this.progress_return
                }
                createLog(JSON.stringify(data), 'Добавление новой группы пользователей', 'user_group', this.$props.user_id)
                this.getGroups();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getGroups() {
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

            var response = await fetch("api/user_group", requestOptions);
            if (response.ok) {
                this.groups = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var addGroupModal = document.getElementById('addGroupModal')
        this.modal        = bootstrap.Modal.getOrCreateInstance(addGroupModal);

        var editGroupModal  = document.getElementById('editGroupModal')
        this.editGroupModal = bootstrap.Modal.getOrCreateInstance(editGroupModal);

        this.$refs.context.contextMenuData = ['Редактировать', 'Удалить']

        this.getGroups();
    }
}
</script>

<style lang="scss" scoped>

$paddingTable : 10px;

.modal-header ~ h5 {
    display : inline-block;
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

.check-1 {
    & + label {
        display     : inline-flex;
        align-items : center;
        user-select : none;

        &::after {
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
    }

    &:checked {
        & + label {
            &::after {
                border-color     : #0b76ef;
                background-color : #0b76ef;
                background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
            }
        }
    }
}

.label-1 {
    font-size : 15px;
    width     : 500px;
}

.check-2 {
    & + label {
        display     : inline-flex;
        align-items : center;
        user-select : none;

        &::after {
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
    }

    &:checked {
        & + label {
            &::after {
                border-color     : #0b76ef;
                background-color : #0b76ef;
                background-image : url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
            }
        }
    }
}

.menu_bottom {
    svg {
        margin-top : 20px;
    }
}

nav {
    display : flex;
    width   : 100%;
    padding : 0 20px;
}

.search-user {
    background : #162c38;
    color      : #f6f6f7;
    padding    : 8px;
    border     : none;
}

.header_top {
    .head_left {
        .head_search {
            button {
                border     : none;
                background : transparent;
                outline    : none;

                img {
                    max-width : 16px;
                }
            }

            input {
                width       : 100%;
                background  : transparent;
                border      : none;
                outline     : none;
                margin-left : 10px;
                font-style  : normal;
                font-size   : 16px;
                line-height : 22px;
                color       : #c6c6c6;

                &::placeholder {
                    opacity : 0.5;
                }
            }
        }
    }

    .head_right {
        .head_link {
            img {
                max-width : 32px;
            }

            span {
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
        }

        .head_ava {
            .head_ava_title {
                h2 {
                    font-style    : normal;
                    font-size     : 16px;
                    line-height   : 22px;
                    color         : #f6f6f7;
                    margin-bottom : 0;
                }

                p {
                    margin-bottom : 0;
                    font-style    : normal;
                    font-size     : 14px;
                    line-height   : 22px;
                    color         : #c6c6c6;
                }
            }
        }

        .dropdown-menu {
            .dropdown-item {
                display     : flex;
                margin-left : 0;

                &:hover {
                    background : var(--table-bg);
                }

                img {
                    height : 35px;
                }

                .head_ava_title {
                    h2 {
                        font-style    : normal;
                        font-size     : 12px;
                        line-height   : 18px;
                        color         : #f6f6f7;
                        margin-bottom : 0;
                    }

                    p {
                        margin-bottom : 0;
                        font-style    : normal;
                        font-size     : 10px;
                        line-height   : 18px;
                        color         : #c6c6c6;
                    }
                }
            }
        }
    }
}

.head_contact {
    span {
        background    : var(--light-green);
        width         : 23px;
        height        : 23px;
        border-radius : 10px;
        display       : block;
        position      : relative;
        left          : 17px;
        top           : -40px;
    }
}

.home {
    width       : 1793px;
    margin-left : 13px;
    position    : relative;
    height      : 815px;

    .header_bottom {
        display         : flex;
        justify-content : space-between;
        align-items     : center;

        .header_bottom_left {
            display     : flex;
            align-items : center;
            gap         : 10px;

            .contact_link {
                display         : flex;
                align-items     : center;
                font-style      : normal;
                font-size       : 16px;
                line-height     : 22px;
                color           : #f6f6f7;
                text-decoration : none;
                padding         : 10px;

                img {
                    margin-right : 10px;
                }
            }

            .search_bottom {
                background    : #122733;
                border-radius : 5px;
                padding       : 10px;
                display       : flex;
                align-items   : center;
                gap           : 10px;

                input {
                    background  : transparent;
                    border      : none;
                    outline     : none;
                    font-style  : normal;
                    font-size   : 16px;
                    line-height : 22px;
                    color       : #c6c6c6;

                    &::placeholder {
                        opacity : 0.5;
                    }
                }
            }

            .btn_select_wrapper {
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

                    &:hover {
                        background    : #4da6aa !important;
                        border-radius : 5px 30px !important;
                    }

                    &::after {
                        display : none;
                    }
                }

                .dropdown_menu {
                    padding       : 10px;
                    border-radius : 5px 30px;
                    background    : #338c90;

                    li {
                        .dropdown-item {
                            padding     : 3px 0 0;
                            font-style  : normal;
                            font-size   : 16px;
                            line-height : 22px;
                            color       : #f6f6f7;

                            &:hover {
                                background : transparent !important;
                            }
                        }
                    }

                    &:hover {
                        background    : #4da6aa !important;
                        border-radius : 5px 30px !important;
                    }
                }
            }

            .setting_button {
                background    : #338c90;
                opacity       : 0.5;
                border-radius : 5px 30px;
                transition    : 0.5s;
                padding       : 10px 20px;
                border        : none;

                &:hover {
                    opacity : 1;
                }
            }
        }

        .header_bottom_right {
            display     : flex;
            align-items : center;
            gap         : 10px;

            .right_button_bottom {
                background    : #338c90;
                opacity       : 0.5;
                border        : none;
                padding       : 10px 20px;
                transition    : 0.4s;
                border-radius : 5px 30px;

                &:hover {
                    opacity : 1;
                }

                &:first-child {
                    opacity : 1;
                }
            }
        }
    }

    table {
        width         : 100%;
        color         : white;
        padding       : 5px;
        border-radius : 10px;

        thead {
            tr {
                th {
                    padding     : 8px;
                    font-weight : normal;
                }
            }
        }

        tr {
            td {
                padding : 8px;
            }
        }
    }
}
</style>
