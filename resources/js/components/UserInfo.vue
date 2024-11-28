<template>
    <div class="main">
        <div class="top">
            <i class="fas fa-user-circle" style="margin-right: 10px;"></i><span>Профиль</span>
        </div>
        <div class="bottom">
            <div class="left">
                <div class="userbox">
                    <div class="ldata_header">Личные данные</div>
                    <table class="fotodata">
                        <tbody>
                        <tr>
                            <td colspan="1" rowspan="4" style="width: 200px;">
                                <div style="display: flex;justify-content: center;">
                                    <div style="overflow: hidden;border-radius: 10px;"><img alt="" height="150" src="img/foto_face.png" width="150">
                                    </div>
                                </div>
                            </td>
                            <td>Фамилия: <span class="ldata_text">Лариков</span></td>
                        </tr>
                        <tr>
                            <td>Имя: <span class="ldata_text">Алексей</span></td>
                        </tr>
                        <tr>
                            <td>Отчество: <span class="ldata_text">Викторович</span></td>
                        </tr>
                        <tr>
                            <td>Дата рож: <span class="ldata_text">12.10.1995</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <span class="ldata_text2">E-Mail</span><span class="ldata_text3">hardyone.official@gmail.com</span>
                    <span class="ldata_text2">Номер тел.</span><span class="ldata_text3">+7(999)-888-55-66</span>
                    <div class="ldata_header" style="margin-top: 20px;">Карьера</div>
                    <span class="ldata_text2">Должность</span><span class="ldata_text3">Управляющий</span>
                    <span class="ldata_text2">Стаж</span><span class="ldata_text3">3 года 6 месяцев</span>
                    <span class="ldata_text2">Место работы</span><span class="ldata_text3">LVLUP Esports RED</span>
                </div>
                <div class="userbox">
                    <div class="ldata_header">Задачи</div>
                </div>
                <div class="userbox">
                    <div class="ldata_header">Блокнот</div>
                    <div class="note_main">
                        <div v-for="s in 5" class="note">
                            <div style="color: #61babe">Запись #1</div>
                            <div style="margin-top: 10px;">Чтобы я не забыл, купить груши, запросить бабосики у леши, написать ему в тг чтобы напомнить и т.д ))</div>
                        </div>
                    </div>
                    <div class="new-rec">
                        <input v-model="newMind" class="input_1" placeholder="Запиши мысль, чтобы не забыть...">
                        <div class="input_1_svg" @click="sendNewMind">
                            <svg fill="none" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.6702 5.874L4.65676 1.28849C2.51812 0.198488 0.192837 2.40104 1.27382 4.49083L2.53368 6.92641C2.88363 7.60296 2.88363 8.39979 2.53368 9.07634L1.27382 11.5119C0.192837 13.6017 2.51812 15.7967 4.65676 14.7143L13.6702 10.1288C15.4433 9.22668 15.4433 6.77607 13.6702 5.874Z" stroke="#338C90" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="right1">
                    <span>Заработная плата</span>
                    <button class="btn btn-success">Мои доходы</button>
                </div>
                <div class="right2">
                    <span>Постоянная ставка</span><br/><span class="right_span">1100</span>
                </div>
                <div class="right3">
                    <span>Процентная ставка</span><br/><span class="right_span">5%</span>
                </div>
                <div class="right4">
                    <span class="r4_span">История смен</span>
                    <div class="scrl">
                        <div v-for="s in shiftsView" class="in1">
                            <div class="in2">{{ s.shift }}</div>
                            <span class="r4_span2">{{ s.status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>
</template>

<script>
import {createLog} from '../logger';

export default {
    name : "UserInfo",
    props: ['user', 'club_id'],
    data() {
        return {
            userData  : {},
            allShifts : [],
            shiftsView: [],
            newMind   : ''
        }
    },
    methods: {
        async sendNewMind() {
            alert();
        },
        async shifts() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", this.userData.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/userinfo/shifts", requestOptions);
            if (response.ok) {
                this.allShifts = await response.json();
                this.allShifts.forEach(function (item, index) {
                    let outArray = {};
                    if (item.close_shift == null) {
                        outArray.shift  = item.open_shift;
                        outArray.status = 'Открытие смены'
                    } else {
                        outArray.shift  = item.close_shift;
                        outArray.status = 'Закрытие смены'
                    }
                    this.shiftsView.push(outArray);
                }.bind(this))
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        this.userData = JSON.parse(this.$props.user);
        this.shifts();
    }
}
</script>

<style scoped>
.new-rec {
    width   : 100%;
    height  : 78px;
    padding : 12px 20px;
}

.input_1 {
    background    : var(--dark-blue-bg-color);
    box-shadow    : 0 1px 10px rgba(0, 0, 0, 0.12);
    border-radius : 10px;
    border        : none;
    padding       : 5px;
    margin-top    : 5px;
    color         : white;
    width         : 100%;
    height        : 40px;
    cursor        : pointer;
    font-size     : 15px;
    position      : relative;
}

.input_1_svg {
    display  : inline-block;
    position : relative;
    bottom   : 33px;
    left     : 385px;
    cursor   : pointer;
}

.main {
    width       : 1794px;
    height      : 816px;
    margin-left : 12px;
    color       : var(--standart-gray);
    font-size   : 20px;
}

.top {
    height      : 60px;
    padding-top : 14px;
}

.bottom {
    height          : 755px;
    display         : flex;
    justify-content : space-between;
}

.left {
    width           : 1438px;
    background      : var(--light-blue-bg-color);
    border-radius   : 20px;
    font-size       : inherit;
    display         : flex;
    justify-content : space-evenly;
    padding-top     : 20px;
}

.right {
    width          : 336px;
    background     : var(--light-blue-bg-color);
    border-radius  : 20px;
    font-size      : inherit;
    display        : flex;
    flex-direction : column;
    align-items    : center;
}

.userbox {
    width         : 452px;
    height        : 590px;
    background    : var(--dark-blue-bg-color);
    border-radius : 20px;
}

.ldata_header {
    width         : 90%;
    height        : 60px;
    display       : flex;
    align-items   : center;
    font-size     : inherit;
    border-bottom : 1px solid #444b60;
    margin-left   : 5%;
}

.ldata_text {
    position : absolute;
    left     : 450px;
}

.ldata_text2 {
    display : inline-block;
    margin  : 20px 50px 0 26px;
    width   : 100px;
}

.ldata_text3 {
    display : inline-block;
}

.fotodata {
    width      : 100%;
    height     : 150px;
    margin-top : 30px;
}

td {
    height : 2rem;
}

.note {
    background    : var(--light-blue-bg-color);
    border-radius : 10px;
    width         : 90%;
    padding       : 20px;
    margin-top    : 20px;
}

.note_main {
    display        : flex;
    flex-direction : column;
    align-items    : center;
    overflow       : auto;
    max-height     : 450px;
}

.right1 {
    display         : flex;
    justify-content : center;
    align-items     : center;
    gap             : 5px;
    margin-top      : 20px;
}

.right2 {
    width          : 200px;
    height         : 125px;
    display        : flex;
    align-items    : center;
    flex-direction : column;
    margin-top     : 20px;
    border-bottom  : 1px solid #4a7369;
}

.right_span {
    font-size  : 70px;
    color      : var(--light-green);
    margin-top : 26px;
}

.right3 {
    width          : 200px;
    display        : flex;
    align-items    : center;
    flex-direction : column;
    border-bottom  : 1px solid #4a7369;
    height         : 120px;
    margin-top     : 20px;
}

.right4 {
    width   : 100%;
    padding : 15px;
    height  : 410px;
}

.r4_span {
    border-bottom  : 1px solid #4a7369;
    width          : 100%;
    display        : block;
    margin-top     : 20px;
    padding-bottom : 10px;
}

.in1 {
    width         : 94%;
    height        : 40px;
    background    : var(--standart-black);
    margin        : 12px auto;
    border-radius : 6px;
}

.in2 {
    width               : 45%;
    height              : 80%;
    background          : var(--regular);
    position            : relative;
    top                 : 4px;
    left                : 4px;
    border-radius       : 4px;
    transition-duration : 300ms;
    display             : inline-block;
    font-size           : 15px;
    padding             : 5px 0 0 6px;
    cursor              : pointer;
}

.r4_span2 {
    display   : inline-block;
    top       : 3px;
    position  : relative;
    left      : 12px;
    font-size : 15px;
}

.in2:hover {
    background : var(--light-green);
    color      : var(--standart-black);
}

.scrl {
    height     : 470px;
    overflow-y : auto;
    position   : relative;
    top        : 10px;
}
</style>
