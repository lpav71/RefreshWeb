<template>
    <div class="account">
        <div class="left-user-account"><i class="fas fa-search fs-5 lupa"></i><input type="text" class="user-search" placeholder="Поиск пользователя">
            <div class="user-search-button"><i class="fas fa-user-plus fs-3 icon-user-plus"></i></div>
        </div>
        <div class="right-user-account">
            <div class="user-search-button"><i class="fas fa-comment fs-3 icon-user-plus"></i></div>
            <div class="user-search-button" style="padding-left: 10px;"><i class="fas fa-bell fs-3 icon-user-plus"></i>
                <div class="notification"><span class="count-notif" style="color: var(--standart-color);font-size: 9px;">10</span></div>
            </div>
            <div class="user-select-button">
                <div class="avatar"><img style="width: 42px;height: 42px;" src="img/logo_test.jpg"></div><select class="user-change">
                <option value="12" selected="">{{ name }}</option>
            </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['name'],
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
.account {
    position: relative;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    padding: 20px 0px;
    width: 1820px;
    height: 94px;
    top: 1px;
    justify-content: space-between;
    padding-right: 15px;
}
.user-search {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 10px 20px;
    gap: 10px;
    width: 376px;
    height: 54px;
    background: linear-gradient(180deg, #284F62 0%, #183F52 100%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    flex: none;
    order: 0;
    flex-grow: 0;
    border: none;
    color: var(--standart-color);
    padding-left: 50px;
    margin-left: -6px;
}
.left-user-account {
    display: flex;
    color: var(--standart-gray);
}
.lupa {
    position: relative;
    left: 30px;
    top: 19px;
    opacity: 0.5;
}
.user-search-button {
    height: 54px;
    width: 52px;
    background: var(--light-blue-bg-color);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    margin-left: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}
.right-user-account {
    display: flex;
}
.icon-user-plus {
    opacity: 0.5;
    color: var(--standart-gray);
}
.user-select-button {
    width: 263px;
    height: 54px;
    background: var(--light-blue-bg-color);
    border-radius: 10px;
    margin-left: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.avatar {
    border-radius: 10px;
    overflow: hidden;
    margin-left: 10px;
}
.user-change {
    background: var(--light-blue-bg-color);
    width: 190px;
    color: var(--standart-gray);
    margin-right: 10px;
    border: none;
    height: 54px;
}
.user-change option {
    color: var(--standart-gray);
    background-color: #122834;
}
.notification {
    width: 15px;
    height: 15px;
    background: var(--light-green);
    border-radius: 11px;
    position: relative;
    left: -9px;
    top: -11px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
