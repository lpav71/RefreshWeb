<template>
    <div class="block-icons">
        <a href="/"><img src="img/logo.svg" style="margin-top: 30px;margin-left: 30px;" alt=""></a>
        <div style="display: flex;flex-direction: column;align-items: center;margin-top: 15px;">
            <img class="left-icon" src="img/1.svg" alt="">
            <a href="game"><img class="left-icon" src="img/2.svg"></a>
            <img class="left-icon" src="img/3.svg" alt="">
            <img class="left-icon" src="img/4.svg" alt="">
            <a href="finduser"><img class="left-icon" src="img/5.svg"></a>
            <a href="booking"><img class="left-icon" src="img/6.svg" alt=""></a>
            <img class="left-icon" src="img/7.svg" alt="">
            <a href="finance"><img class="left-icon" src="img/8.svg" alt=""></a>
            <img class="left-icon" src="img/9.svg" alt="">
        </div>
        <div style="display: flex;flex-direction: column;align-items: center;margin-top: 354px;">
            <img class="left-icon" src="img/10.svg" alt="">
            <img class="left-icon" src="img/11.svg" alt="">
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
:root {
    --dark-blue-bg-color: linear-gradient(180deg, #172D39 0%, #122834 100%);
    --light-blue-bg-color: linear-gradient(180deg, #284F62 0%, #183F52 100%);
    --dark-green: #4DA6AA;
    --light-green: #6FC8CC;
    --standart-green: #01B353;
    --standart-color: #F6F6F7;
    --standart-red: #FA4C4C;
    --standart-gray: #C6C6C6;
    --standart-black: #122733;
}
.user-change option {
    color: var(--standart-gray);
    background-color: #122834;
}
.block-icons {
    width: 100px;
    height: 1080px;
}
.left-icon {
    width: 23px;
    margin-top: 25px;
}
</style>
