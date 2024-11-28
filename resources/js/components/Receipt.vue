<template>
    <div class="home">
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
            <button class="btn btn-success" @click="allReceipts">Сбросить</button>&emsp;
        </div>

        <table>
            <thead>
            <tr>
                <th>Имя сотрудника</th>
                <th>Дата</th>
                <th>Количество</th>
                <th>Документ</th>
                <th>Поставщик</th>
                <th>Продукт</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f, index) in receiptData">
                <td>{{ f.admin }}</td>
                <td>{{ f.date }}</td>
                <td>{{ f.num }}</td>
                <td>{{ f.doc }}</td>
                <td>{{ f.description }}</td>
                <td>{{ f.product }} {{ f.product_param }}</td>
            </tr>
            </tbody>
        </table>
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
            receiptData: [],
            admins     : [],
            admin      : '',
            start_date : '',
            end_date   : ''
        }
    },
    methods: {
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
            } else {
                this.$refs.message.modal.show();
            }
        },
        async allReceipts(shift_num) {
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

            var response = await fetch("api/warehouse/allreceipts", requestOptions);
            if (response.ok) {
                this.receiptData = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        enter(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        async filter() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("start_date", this.start_date);
            urlencoded.append("end_date", this.end_date);
            urlencoded.append("admin", this.admin);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/warehouse/filter", requestOptions);
            if (response.ok) {
                var result       = await response.json();
                this.receiptData = result;
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        this.allReceipts();
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
    height      : 815px;

    table {
        width         : 100%;
        color         : white;
        background    : var(--light-blue-bg-color);
        padding       : 5px;
        border-radius : 10px;

        thead tr th {
            padding     : 8px;
            font-size   : initial;
            font-weight : initial;
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
