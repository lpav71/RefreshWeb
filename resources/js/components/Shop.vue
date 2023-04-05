<template>
    <div class="main">
        <div class="left">
            <div style="display: flex;flex-direction: column;align-items: center;width: 250px;height: 220px;justify-content: space-between;"><span>Выберите пользователя</span>
                <div style="margin-top: -33px;"><i class="fas fa-search lupa2"></i><input class="select_user" type="text" placeholder="Поиск логина" /></div>
                <div class="user_name"><img src="images/shop/ava.svg" style="width: 22px;margin-top: 10px;margin-left: 10px;" /><i class="far fa-star" style="margin-left: 119px;position: relative;top: 5px;left: 71px;"></i>
                    <div style="display: inline-block;position: relative;top: -30px;left: 28px;"><span style="display: inline-block;position: relative;top: 35px;left: -136px;">gg.August</span></div>
                </div>
                <div class="info"><img src="images/shop/rub.png" width="16" height="16" style="margin-top: 12px;margin-left: 17px;" /><span class="rub_summa">500</span><img src="images/shop/coin.png" width="16" height="16" style="margin-top: 10px;margin-left: 97px;" /><span class="rub_summa" style="color: #FFCD00;">250</span></div>
            </div><button class="btn btn-danger" type="button" style="width: 250px;background: var(--dark-green);border: none;">Нет логина [гость]</button><span style="margin-bottom: -24px;margin-top: 35px;">Корзина</span>
            <div class="cart">
                <div class="cart_element"><span style="padding-right: 0px;">x5</span>
                    <div class="cart_name"><span>Напиток Черноголовка лимонад 0.5л</span></div><i class="far fa-window-close"></i>
                </div>
                <div class="cart_element"><span style="padding-right: 0px;">x5</span>
                    <div class="cart_name"><span>Напиток Черноголовка лимонад 0.5л</span></div><i class="far fa-window-close"></i>
                </div>
                <div class="cart_element"><span style="padding-right: 0px;">x5</span>
                    <div class="cart_name"><span>Напиток Черноголовка лимонад 0.5л</span></div><i class="far fa-window-close"></i>
                </div>
                <div class="cart_element"><span style="padding-right: 0px;">x5</span>
                    <div class="cart_name"><span>Напиток Черноголовка лимонад 0.5л</span></div><i class="far fa-window-close"></i>
                </div>
                <div class="cart_element"><span style="padding-right: 0px;">x5</span>
                    <div class="cart_name"><span>Напиток Черноголовка лимонад 0.5л</span></div><i class="far fa-window-close"></i>
                </div>
            </div>
            <div style="display: flex;flex-direction: column;align-items: center;padding: 0px;width: 250px;height: 158px;margin-top: 45px;"><span>Применить промокод</span><input class="user_name" type="text" placeholder="refresh 2023" style="text-align: center;" /><span>Итого</span>
                <div class="user_name"><img src="images/shop/rub.png" width="16" height="16" style="margin-top: 12px;margin-left: 17px;" /><span class="rub_summa">500</span><img src="images/shop/coin.png" width="16" height="16" style="margin-top: 10px;margin-left: 97px;" /><span class="rub_summa" style="color: #FFCD00;">250</span></div>
            </div><button class="btn btn-danger" type="button" style="width: 250px;">Оплатить</button>
        </div>
        <div class="right">
            <div class="top"><img src="images/shop/2.svg" /><span style="margin-left: 14px;">Магазин</span><i class="fas fa-search lupa"></i><input class="input_shop" type="text" placeholder="Поиск товаров" /><button class="butt" type="button">Все</button><button class="butt" type="button">Товары</button><button class="butt" type="button">Пакетные предложения</button><button class="butt" type="button">Услуги</button></div>
            <div class="bottom" style="border-radius: 20px;padding: 30px;">
                <div class="goods" v-for="(g, index) in goods">
                    <div class="goods_img"><img :src="g.icon" height="200" /></div>
                    <div class="goods_text"><span>{{ g.types }}</span>
                        <div class="goods_price">
                            <div><img src="images/shop/rub.svg" /><span>{{ g.price }}</span></div>
                            <div><img src="images/shop/logo.svg" /><span>н.у.</span></div>
                        </div>
                    </div>
                    <div class="goods-btn"><span>{{ g.product }} {{ g.product_param }}</span><button class="goods_cart" type="button">В корзину</button></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "shop",
    props: ['club_id'],
    data() {
        return {
            goods: []
        }
    },
    methods: {
        async getAll() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", "2");

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("https://localhost:7150/api/shop/get", requestOptions);
            this.goods = await response.json();
        }
    },
    mounted() {
        this.getAll();
    }
}
</script>

<style scoped>
.main {
    width: 1790px;
    height: 945px;
    display: flex;
    color: white;
}

.left {
    width: 330px;
    height: 945px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 40px;
    background: var(--light-blue-bg-color);
    border-radius: 20px;
    justify-content: space-between;
    padding-bottom: 43px;
}

.right {
    width: 100%;
}

.top {
    width: 1490px;
    height: 42px;
    margin-left: 20px;
    display: flex;
    justify-content: start;
    align-items: center;
}

.bottom {
    width: 1490px;
    height: 881px;
    margin-left: 20px;
    margin-top: 20px;
    background: var(--light-blue-bg-color);
    display: flex;
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

.lupa {
    position: relative;
    left: 48px;
    opacity: 0.50;
    top: 0;
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

.user_name {
    width: 250px;
    height: 42px;
    background: var(--standart-black);
    border-radius: 7px;
    border: none;
    color: var(--standart-gray);
}

.info {
    width: 250px;
    height: 42px;
}

.cart_element {
    width: 170px;
    background: var(--dark-green);
    border-radius: 10px;
    margin-top: 19px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

.select_user {
    background: var(--standart-black);
    height: 42px;
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 10px 20px;
    gap: 10px;
    width: 250px;
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px;
    flex: none;
    order: 0;
    flex-grow: 0;
    border: none;
    color: var(--standart-color);
    padding-left: 50px;
}

.lupa2 {
    position: relative;
    top: 34px;
    left: 10px;
}

.rub_summa {
    display: inline-block;
    position: relative;
    top: 7px;
    left: 5px;
}

.cart_name {
    width: 120px;
}

.cart_name span {
    font-size: 12px;
    line-height: 1.2;
    display: inline-block;
    margin-left: 13px;
    margin-top: 4px;
}

.cart {
    display: flex;
    width: 250px;
    height: 300px;
    flex-direction: column;
    align-items: center;
    margin-top: 24px;
    background: var(--dark-blue-bg-color);
    border-radius: 10px;
    overflow: auto;
}

::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
    background-color: #142A36;
}

::-webkit-scrollbar {
    width: 12px;
    background-color: #142A36;
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: var(--dark-green);
}

.goods {
    width: 156px;
    height: 250px;
    margin-right: 20px;
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
    height: 24px;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    align-items: center;
}

.goods_price {
    width: 78px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.goods-btn {
    width: 154px;
    height: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
}

.goods_cart {
    border: none;
    border-radius: 4px;
    background: var(--dark-green);
    color: var(--standart-color);
}
</style>
