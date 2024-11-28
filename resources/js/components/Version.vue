<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left">
                <div class="contact_link">
                    <img alt="" src="/images/head_bottom/contact.svg"/>
                    Версии ПО
                </div>
            </div>
            <div class="header_bottom_right">
                <button class="btn btn-success">Список изменений</button>
                <button class="btn btn-success">Стандарт</button>
            </div>
        </div>
        <table class="table table-borderless t1" style="margin-top: 20px;">
            <thead>
            <tr>
                <th>Все</th>
                <th>Номер компьютера</th>
                <th>Установленная версия</th>
                <th>Новейшая версия ПО</th>
                <th>Статус</th>
            </tr>
            </thead>
        </table>
        <div class="fon">
            <table class="table table-borderless t2">
                <tbody>
                <tr v-for="(user, index) in 10">
                    <td>{{ user.login }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.surname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.amount }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <message ref="message"></message>
    <system-message ref="sysMessage"></system-message>
</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id'],
    data() {
        return {}
    },
    methods: {},
    mounted() {

    }
}
</script>

<style lang="scss" scoped>

$paddingTable : 10px;

.modal-header {
    & ~ h5 {
        display : inline-block;
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

.fon {
    height        : 667px;
    background    : var(--light-blue-bg-color);
    border-radius : 10px;
}

.check-1 {
    & + label {
        display     : inline-flex;
        align-items : center;
        user-select : none;
    }
}


.check-1 {
    & + label {
        &::after {
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

.check-2 {
    & + label {
        display     : inline-flex;
        align-items : center;
        user-select : none;
    }
}

.check-2 {
    & + label {
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

img {
    height : 35px;
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
                font-family     : "Russia", sans-serif;
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
        }

        .header_bottom_right {
            display     : flex;
            align-items : center;
            gap         : 10px;

            .right_button_bottom {
                background    : #338c90;
                border        : none;
                padding       : 10px 20px;
                transition    : 0.4s;
                border-radius : 10px;
            }
        }
    }

    table {
        width         : 100%;
        color         : white;
        padding       : 5px;
        border-radius : 10px;

        thead tr th {
            padding-left  : 20px;
            padding-right : 20px;
            font-size     : initial;
            font-weight   : initial;
        }

        tr td {
            padding : 8px;
        }
    }
}

</style>
