<template>
    <div v-if="showCalendar" class="overlay" @click="hideDiv"></div>
    <div v-show="showCalendar" id="calendar" ref="calendar" :class="{show: showCalendar}" :style="{top: top + 'px', left: left + 'px'}" class="calendar">
        <div class="calendar-header">
            <div class="c1">
                <div class="plus-minus" @click="currentMonth--">-</div>
                <div class="month-header">{{ textMonth }}</div>
                <div class="plus-minus" @click="currentMonth++">+</div>
            </div>
            <div class="spacer"></div>
            <div class="c1">
                <div class="plus-minus" @click="currentYear--">-</div>
                <div class="month-header">{{ currentYear }}</div>
                <div class="plus-minus" @click="currentYear++">+</div>
            </div>
        </div>


        <div class="weekdays">
            <div v-for="day in daysOfWeek" :key="day" class="weekday">
                {{ day }}
            </div>
        </div>

        <div class="days">
            <div
                v-for="day in daysInMonth"
                :key="day"
                :class="{ 'today': day === currentDay, 'selected-day': day === selectedDay }"
                class="day"
                @click="selectDay(day)"
            >
                {{ day }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "calendar",
    data() {
        return {
            daysOfWeek  : ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
            currentMonth: 0,
            currentYear : 0,
            currentDay  : 0,
            selectedDay : null,
            textMonth   : "",
            showCalendar: false,
            top         : null,
            left        : null
        };
    },
    computed: {
        daysInMonth() {
            const date        = new Date(this.currentYear, this.currentMonth, 1);
            this.textMonth    = date.toLocaleString("ru-RU", {
                month: "long"
            });
            const daysInMonth = [];
            var dOfWeek       = date.getDay() - 1;
            if (dOfWeek === -1)
                dOfWeek = 6;
            for (var i = 0; i < dOfWeek; i++) {
                daysInMonth.push('');
            }
            while (date.getMonth() === this.currentMonth) {
                daysInMonth.push(date.getDate());
                date.setDate(date.getDate() + 1);
            }
            return daysInMonth;
        },
    },
    methods : {
        hideDiv(event) {
            if (!event.target.closest('#calendar')) {
                this.hide();
            }
        },
        show() {
            this.showCalendar = true;
        },
        hide() {
            this.showCalendar = false;
        },
        selectDay(day) {
            this.selectedDay = day;
            this.$emit('item-selected');
        },
    },
    created() {
        const currentDate = new Date();
        var c             = currentDate.toLocaleString("ru-RU", {
            month : "long",
            year  : 'numeric',
            day   : 'numeric',
            hour  : 'numeric',
            minute: 'numeric'
        });
        this.currentMonth = currentDate.getMonth();
        this.textMonth    = currentDate.toLocaleString("ru-RU", {
            month: "long"
        });
        this.currentYear  = currentDate.getFullYear();
        this.currentDay   = currentDate.getDate();
    },
    mounted() {
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                this.hide();
            }
        }.bind(this));
    }
}
</script>

<style scoped>
.overlay {
    position : fixed;
    top      : 0;
    left     : 0;
    width    : 100%;
    height   : 100%;
    /*background-color: rgba(0, 0, 0, 0.5);*/
}

.c1 {
    width           : 100px;
    display         : flex;
    justify-content : center;
    height          : 26px;
}

.spacer {
    width : 20px;
}

.plus-minus {
    height          : 20px;
    width           : 20px;
    background      : var(--light-blue-bg-color);
    display         : flex;
    justify-content : center;
    align-items     : center;
    border-radius   : 20px;
    cursor          : pointer;
}

.calendar-header {
    display         : flex;
    justify-content : center;
}

.calendar {
    position      : absolute;
    opacity       : 0;
    z-index       : 100;
    width         : 230px;
    box-shadow    : 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius : 5px;
    padding       : 10px;
    background    : var(--light-blue-bg-color);
    color         : var(--standart-gray);
    user-select   : none;
}

.show {
    opacity : 1;
}

.month-header {
    font-size     : 11px;
    text-align    : center;
    margin-bottom : 10px;
    columns       : 1;
    width         : 70px;
}

.weekdays {
    display         : flex;
    justify-content : space-between;
    margin-bottom   : 10px;
}

.weekday {
    font-size : 14px;
}

.days {
    display               : grid;
    grid-template-columns : repeat(7, 1fr);
    grid-gap              : 5px;
}

.day {
    font-size       : 14px;
    display         : flex;
    justify-content : center;
    align-items     : center;
    border-radius   : 5px;
    cursor          : pointer;
    height          : 30px;
}

.today {
    background-color : var(--light-green);
    color            : var(--standart-black)
}

.selected-day {
    background-color : #707070;
    color            : #fff;
}
</style>
