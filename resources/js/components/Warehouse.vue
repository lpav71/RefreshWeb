<template>
<div class="home">
    <div class="header">
        <div class="left">
            <div class="top"><img src="img/4.svg"/><span style="margin-left: 14px;">Склад</span><i
                class="fas fa-search lupa"></i><input @keydown="enter" v-model="product_name" class="input_shop"
                                                      type="text" placeholder="Поиск товаров"/>
                <button class="butt" type="button">Все</button>
                <button class="butt" type="button">Товары</button>
                <button class="butt" type="button">Услуги</button>
                <button class="butt" type="button">Скоро закончатся</button>
            </div>
        </div>
        <div class="right">
            <button class="butt" type="button">Внесение</button>
            <button class="butt" type="button">Изъятие</button>
            <button class="butt" type="button">Добавить</button>
        </div>
    </div>
    <div class="bottom">
        <div class="in-bottom">
            <div class="goods" v-for="(g, index) in goods">
                <div class="goods_img"><img :src="g.icon" height="200"></div>
                <div class="goods_text">
                    <div>{{ g.name }}</div><br><div>{{ g.product }} {{ g.product_param }}</div>
                </div>
                <div class="goods-btn">
                    <span>{{ g.num }}</span>
                    <button class="goods_cart" @click="toCart(index)" type="button"><i class="fa fa-edit fa-lg"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['club_id'],
    data() {
        return {
            product_name: '',
            goods: null
        }
    },
    methods: {
        async getAll() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/shop/get", requestOptions);
            this.goods = await response.json();
        }
    },
    mounted() {
        this.getAll();
    }
}
</script>

<style scoped>
.home {
    width: 1793px;
    height: 947px;
    color: var(--standart-gray);
    margin-left: 11px;
}
.home .header {
    display: flex;
    justify-content: space-between;
}
.home .header .left {
    width: 1060px;
}
.home .header .right {
    width: 400px;
    display: flex;
    justify-content: end;
}
.bottom {
    display: flex;
    width: 1793px;
    height: 855px;
    background: var(--light-blue-bg-color);
    margin-top: 20px;
    border-radius: 20px;
    padding: 20px;
}
.in-bottom {
    overflow: auto;
    flex-wrap: wrap;
    display: flex;
}
.butt {
    background: var(--disable);
    border: none;
    border-radius: 5px 30px;
    height: 42px;
    margin-left: 20px;
    min-width: 94px;
    padding-right: 20px;
    padding-left: 20px;
}
.lupa {
    position: relative;
    left: 48px;
    opacity: 0.50;
    top: 0;
}
.top {
    width: 1490px;
    height: 42px;
    display: flex;
    justify-content: start;
    align-items: center;
}
.input_shop {
    margin-left: 20px;
    background: var(--standart-black);
    height: 42px;
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 10px 20px;
    gap: 10px;
    width: 376px;
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    flex: none;
    order: 0;
    flex-grow: 0;
    border: none;
    color: var(--standart-color);
    padding-left: 50px;
}
.goods {
    width: 178px;
    height: 281px;
    background: var(--standart-black);
    margin-right: 15px;
    padding: 11px;
    border-radius: 12px;
    margin-bottom: 15px;
}

.goods_img {
    width: 156px;
    height: 200px;
    display: flex;
    justify-content: center;
    background: var(--standart-color);
    overflow: hidden;
    border-radius: 10px;
}

.goods_text {
    width: 156px;
    height: 22px;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    flex-direction: column;
    line-height: 8px;
    margin-top: 7px;
}

.goods-btn {
    width: 154px;
    height: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
    margin-top: 4px;
}

.goods_cart {
    border: none;
    border-radius: 4px;
    background: var(--dark-green);
    color: var(--standart-color);
    width: 30px;
    height: 25px;
}
</style>
