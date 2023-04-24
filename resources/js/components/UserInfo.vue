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
                                <div style="overflow: hidden;border-radius: 10px;"><img width="150" height="150" src="img/foto_face.png" alt=""></div>
                            </div>
                        </td>
                        <td>Фамилия: <span class="ldata_text">Лариков</span></td></tr>
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

                    <div v-for="s in 5" class="note"><div style="color: #61BABE">Запись #1</div><div style="margin-top: 10px;">Чтобы я не забыл, купить груши, запросить бабосики у леши, написать ему в тг чтобы напомнить и т.д ))</div></div>

                </div>
            </div>
        </div>
        <div class="right">
            <div class="right1">
                <span>Заработная плата</span><button class="btn b1">Мои доходы</button>
            </div>
            <div class="right2">
                <span>Постоянная ставка</span><br /><span class="right_span">1100</span>
            </div>
            <div class="right3">
                <span>Процентная ставка</span><br /><span class="right_span">5%</span>
            </div>
            <div class="right4">
                <span class="r4_span">История смен</span>
                <div class="scrl">
                    <div class="in1" v-for="t in 8">
                        <div class="in2">08.05.2023 15:25</div><span class="r4_span2">Закрытие смены</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "UserInfo",
    props: ['user'],
    data() {
        return {
            userData: {}
        }
    },
    methods: {

    },
    mounted() {
        this.userData = JSON.parse(this.$props.user);
    }
}
</script>

<style scoped>
.main {
    width: 1794px;
    height: 960px;
    margin-left: 12px;
    color: var(--standart-gray);
    font-size: 20px;
}
.top {
    height: 60px;
    padding-top: 14px;
}
.bottom {
    height: 900px;
    display: flex;
    justify-content: space-between;
}
.left {
    width: 1438px;
    background: var(--light-blue-bg-color);
    border-radius: 20px;
    font-size: inherit;
    display: flex;
    justify-content: space-evenly;
    padding-top: 20px;
}
.right {
    width: 336px;
    background: var(--light-blue-bg-color);
    border-radius: 20px;
    font-size: inherit;
}
.userbox {
    width: 452px;
    height: 590px;
    background: var(--dark-blue-bg-color);
    border-radius: 20px;
}
.ldata_header {
    width: 90%;
    height: 60px;
    display: flex;
    align-items: center;
    font-size: inherit;
    border-bottom: 1px solid #444b60;
    margin-left: 5%;
}
.ldata_text {
    position: absolute;
    left: 450px;
}
.ldata_text2 {
    display: inline-block;
    margin: 20px 50px 0 26px;
    width: 100px;
}
.ldata_text3 {
    display: inline-block;
}
.fotodata {
    width: 100%;
    height: 150px;
    margin-top: 30px;
}
td {
    height: 2rem;
}
.note {
    background: var(--light-blue-bg-color);
    border-radius: 10px;
    width: 90%;
    padding: 20px;
    margin-top: 20px;
}
.note_main {
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: auto;
    max-height: 510px;
}
.b1 {
    background: var(--light-green);
    border-radius: 5px 30px 5px 30px;
}
.right {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.right1 {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 20px;
}
.right2 {
    width: 200px;
    height: 125px;
    display: flex;
    align-items: center;
    flex-direction: column;
    margin-top: 20px;
    border-bottom: 1px solid #4a7369;
}
.right_span {
    font-size: 70px;
    color: var(--light-green);
    font-weight: bold;
    margin-top: 26px;
}
.right3 {
    width: 200px;
    display: flex;
    align-items: center;
    flex-direction: column;
    border-bottom: 1px solid #4a7369;
    height: 120px;
    margin-top: 20px;
}
.right4 {
    width: 100%;
    padding: 15px;
}
.r4_span {
    border-bottom: 1px solid #4a7369;
    width: 100%;
    display: block;
    margin-top: 20px;
    padding-bottom: 10px;
}
.in1 {
    width: 94%;
    height: 40px;
    background: var(--standart-black);
    margin: 12px auto;
    border-radius: 6px;
}
.in2 {
    width: 45%;
    height: 80%;
    background: var(--regular);
    position: relative;
    top: 4px;
    left: 4px;
    border-radius: 4px;
    transition-duration: 300ms;
    display: inline-block;
    font-size: 15px;
    padding: 5px 0 0 6px;
}
.r4_span2 {
    display: inline-block;
    top: 3px;
    position: relative;
    left: 12px;
    font-size: 15px;
}
.in2:hover {
    background: var(--light-green);
    color: var(--standart-black);
}
.scrl {
    height: 470px;
    overflow-y: auto;
    position: relative;
    top: 10px;
}
</style>
