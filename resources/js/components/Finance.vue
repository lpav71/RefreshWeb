<template>
    <div class="home">
        <a ref="csvfile" :href="filename" download="" style="display: none">{{ filename }}</a>
        <div class="filter">
            <label for="start">Начало периода</label>&emsp;
            <input id="start" v-model="start_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowStart">&emsp;

            <label for="end">Конец периода</label>&emsp;
            <input id="end" v-model="end_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowEnd">&emsp;

            <label for="admin">Администратор</label>&emsp;
            <select id="admin" v-model="admin" class="select-admin">
                <option value="-1">Все</option>
                <option v-for="a in admins" :value="a.id">{{ a.name }}</option>
            </select>&emsp;

            <button class="btn btn-success" @click="filter">Фильтр</button>&emsp;
            <button class="btn btn-success" @click="getAllFinance">Сбросить</button>&emsp;
            <button class="btn btn-success" @click="generateReport"><img alt="" src="img/download-bold.svg" style="margin-bottom: 5px;"></button>&emsp;
        </div>

        <table>
            <thead>
            <tr>
                <th>Имя сотрудника</th>
                <th>Номер смены</th>
                <th>Начало смены</th>
                <th>Конец смены</th>
                <th>Наличными</th>
                <th>Кол-во операций</th>
                <th>Безнал</th>
                <th>Кол-во операций</th>
                <th>Возврат нал</th>
                <th>Кол-во операций</th>
                <th>Возврат безнал</th>
                <th>Кол-во операций</th>
                <th>Бонусами</th>
                <th>Кол-во операций</th>
                <th>Статус</th>
                <th>Нал продажи</th>
                <th>Кол-во операций</th>
                <th>Безнал продажи</th>
                <th>Кол-во операций</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f, index) in finance">
                <td>{{ f.name }}</td>
                <td>{{ f.shift }}</td>
                <td>{{ f.open_shift }}</td>
                <td>{{ f.close_shift }}</td>
                <td>{{ f.cash }}</td>
                <td>{{ f.cash_num }}</td>
                <td>{{ f.nocash }}</td>
                <td>{{ f.nocash_num }}</td>
                <td>{{ f.return_cash }}</td>
                <td>{{ f.return_cash_num }}</td>
                <td>{{ f.return_nocash }}</td>
                <td>{{ f.return_nocash_num }}</td>
                <td>{{ f.bonus }}</td>
                <td>{{ f.bonus_num }}</td>
                <td>{{ f.status }}</td>
                <td>{{ f.shop_cash }}</td>
                <td>{{ f.shop_cash_num }}</td>
                <td>{{ f.shop_nocash }}</td>
                <td>{{ f.shop_nocash_num }}</td>
                <td>
                    <button class="btn btn-success" @click="finShow(index)">финансы</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно -->
    <div id="financeModal" aria-hidden="true" aria-labelledby="financeModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="financeModalLabel" class="modal-title">Финансы</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                        <tr>
                            <th>Транзакция</th>
                            <th>Клиент ID</th>
                            <th>Администратор</th>
                            <th>Смена</th>
                            <th>Сумма</th>
                            <th>Тип</th>
                            <th>Дата и время</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(f, index) in financeData">
                            <td>{{ f.id }}</td>
                            <td>{{ f.user_id }}</td>
                            <td>{{ f.admin }}</td>
                            <td>{{ f.shift }}</td>
                            <td>{{ f.amount }}</td>
                            <td>{{ f.name }}</td>
                            <td>{{ f.dt_operation }}</td>
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

    <calendar ref="calandarStart" @item-selected="calendarSelectStart"></calendar>
    <calendar ref="calandarEnd" @item-selected="calendarSelectEnd"></calendar>
    <message ref="message"></message>

</template>

<script>

export default {
    props: ['club_id'],
    data() {
        return {
            finance    : [],
            modal      : null,
            financeData: [],
            admins     : [],
            admin      : '',
            start_date : '',
            end_date   : '',
            filename   : ''
        }
    },
    methods: {
        async generateReport() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");
            var raw = JSON.stringify({
                "collection": this.finance,
                "header"    : "Имя сотрудника, Номер смены, Начало смены, Конец смены, Наличными, Кол-во операций, Безнал, Кол-во операций, Бонусами, Кол-во операций, Возврат нал, Кол-во операций, Возврат безнал, Кол-во операций, Нал продажи, Кол-во операций, Безнал продажи, Кол-во операций Статус,"
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
        finShow(i) {
            let shift_number = this.finance[i].shift;
            this.financeFromBD(shift_number);
            this.modal.show();
        },
        async financeFromBD(shift_num) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("shift_num", shift_num);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/data", requestOptions);
            if (response.ok) {
                this.financeData = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        enter(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        async getAllFinance() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/all", requestOptions);
            if (response.ok) {
                var result = await response.json();
                console.log(result);
                this.finance = result;
            } else {
                this.$refs.message.modal.show();
            }
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
            this.admins  = await response.json();
        },
        async filter() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("admin_id", this.admin);
            urlencoded.append("start_date", this.start_date);
            urlencoded.append("end_date", this.end_date);
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/filter", requestOptions);
            if (response.ok) {
                this.finance = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        var financeModal = document.getElementById('financeModal')
        this.modal       = bootstrap.Modal.getOrCreateInstance(financeModal);

        this.getAllFinance();
        this.getAdmins();
    }
}
</script>

<style lang="scss" scoped>

input[type="date"]::-webkit-calendar-picker-indicator {
    display : none;
}

.home {
    width       : 1795px;
    margin-left : 11px;

    table {
        width         : 100%;
        color         : white;
        background    : var(--light-blue-bg-color);
        padding       : 5px;
        font-size     : 11px;
        border-radius : 10px;

        thead tr th {
            padding : 8px;
        }

        tr td {
            padding : 8px;
        }
    }
}

.filter {
    margin-bottom : 20px;
}

option {
    background : var(--dark-blue-bg-color);
}

label {
    color : var(--standart-gray);
}

.input_1 {
    background    : var(--light-blue-bg-color);
    box-shadow    : 0 1px 10px rgba(0, 0, 0, 0.12);
    border-radius : 10px;
    border        : none;
    padding       : 5px;
    margin-top    : 5px;
    color         : white;
    width         : 200px;
    height        : 40px;
}

.select-admin {
    background    : var(--light-blue-bg-color);
    width         : 290px;
    color         : var(--standart-gray);
    margin-right  : 10px;
    border        : none;
    border-radius : 10px;
    padding       : 5px;
    margin-top    : 5px;
    height        : 40px;
}

select option {
    margin      : 40px;
    background  : #122834;
    color       : var(--standart-gray);
    text-shadow : 0 1px 0 rgba(0, 0, 0, 0.4);
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
</style>
