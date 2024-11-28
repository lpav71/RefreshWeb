<template>
    <div class="home">
        <div class="filter">
            <label for="start">Начало периода</label>&emsp;
            <input id="start" v-model="start_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowStart">&emsp;

            <label for="end">Конец периода</label>&emsp;
            <input id="end" v-model="end_date" class="input_1" placeholder="Выберите дату" type="text" @click="calendarShowEnd">&emsp;

            <label for="admin">Зона</label>&emsp;
            <select id="admin" v-model.number="selectedZone" class="select-admin">
                <option value="-1">Все</option>
                <option v-for="a in zones" :value="a.num">{{ a.name }}</option>
            </select>&emsp;

            <button class="btn btn-success" @click="showStatistic">Показать</button>&emsp;
        </div>

        <table>
            <thead>
            <tr>
                <th>Название тарифа</th>
                <th>Тип тарифа</th>
                <th>Игровая зона</th>
                <th>Количество активаций</th>
                <th>День недели</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f, index) in statistic">
                <td>{{ f.name }}</td>
                <td>{{ f.tariff_type_text }}</td>
                <td>{{ f.zone }}</td>
                <td>{{ f.count }}</td>
                <td>{{ f.week_day_text }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <calendar ref="calandarStart" @item-selected="calendarSelectStart"></calendar>
    <calendar ref="calandarEnd" @item-selected="calendarSelectEnd"></calendar>
    <message ref="message"></message>

</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id'],
    data() {
        return {
            statistic   : [],
            modal       : null,
            zones       : [],
            selectedZone: -1,
            start_date  : '',
            end_date    : ''
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
            var t                         = start.getBoundingClientRect();
            this.$refs.calandarStart.top  = t.bottom + 10;
            this.$refs.calandarStart.left = t.left;
            this.$refs.calandarStart.show();
        },
        calendarShowEnd() {
            var t                       = end.getBoundingClientRect();
            this.$refs.calandarEnd.top  = t.bottom + 10;
            this.$refs.calandarEnd.left = t.left;
            this.$refs.calandarEnd.show();
        },
        finShow(i) {
            let shift_number = this.finance[i].shift;
            this.financeFromBD(shift_number);
            this.modal.show();
        },
        enter(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        async getZone() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tariff/zone", requestOptions);
            if (response.ok) {
                this.zones = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async showStatistic() {
            var dayWeek   = {
                1: 'Понедельник',
                2: 'Вторник',
                3: "Среда",
                4: "Четверг",
                5: "Пятница",
                6: "Суббота",
                7: "Воскресенье",
            }
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id_zone", this.selectedZone);
            urlencoded.append("time_start", this.start_date);
            urlencoded.append("time_stop", this.end_date);
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/booking/statistic", requestOptions);
            if (response.ok) {
                this.statistic = await response.json();
                this.statistic.forEach(function (item, index) {
                    if (this.statistic[index].tariff_type == 1) {
                        this.statistic[index].tariff_type_text = 'Пакет минут'
                    } else {
                        this.statistic[index].tariff_type_text = 'Поминутный'
                    }
                    this.statistic[index].week_day_text = dayWeek[this.statistic[index].week_day];
                }.bind(this))
            } else {
                this.$refs.message.modal.show();
            }
        },
    },
    mounted() {
        this.getZone();
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
        font-size     : 11px;
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
