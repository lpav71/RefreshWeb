<template>
    <div class="main">
        <div class="left">
            <div style="display: flex;flex-direction: column;align-items: center;width: 250px;height: 220px;justify-content: space-between;"><span>Выберите пользователя</span>
                <div style="margin-top: -33px;">
                    <i class="fas fa-search lupa2"></i>
                    <input class="select_user" type="text" @keydown="searchClientToKey" @input="searchClients" v-model="searchQuery" placeholder="Поиск логина" />
                </div>
                <div class="popup" v-show="findWindow" ref="findBlock">
                    <ul>
                        <li v-for="(f, i) in filteredClients" @click="selectFindClient(i)">{{ f.login }}</li>
                    </ul>
                </div>
                <div class="user_name">
                    <img src="images/shop/ava.svg" style="width: 22px;margin-top: 10px;margin-left: 10px;" />
                    <i class="far fa-star" style="margin-left: 119px;position: relative;top: 5px;left: 71px;"></i>
                    <div style="display: inline-block;position: relative;top: -30px;left: 28px;">
                        <span class="client_login">{{ findClient.login }}</span>
                    </div>
                </div>
                <div class="info">
                    <img src="images/shop/rub.png" width="16" height="16" style="margin-top: 12px;margin-left: 17px;" />
                    <span class="rub_summa">{{ findClient.amount }}</span>
                    <img src="images/shop/coin.png" width="16" height="16" style="margin-top: 10px;margin-left: 97px;" />
                    <span class="rub_summa" style="color: #FFCD00;">{{ findClient.bonus }}</span>
                </div>
            </div>
            <button class="btn btn-danger" @click="clearClient" type="button" style="width: 250px;background: var(--dark-green);border: none;">Нет логина [гость]</button>
            <span style="margin-bottom: -24px;margin-top: 35px;">Корзина</span>
            <div class="cart">
                <div v-for="(c, index) in cart" class="cart_element">
                    <span style="padding-right: 0px;">x{{ c.qty }}</span>
                    <div class="cart_name">
                        <span>{{ c.name }}</span>
                    </div>
                    <i class="far fa-window-close" style="cursor: pointer" @click="del(index)"></i>
                </div>
            </div>
            <div style="display: flex;flex-direction: column;align-items: center;padding: 0px;width: 250px;height: 158px;margin-top: 45px;"><span>Применить промокод</span><input class="user_name" type="text" placeholder="refresh 2023" style="text-align: center;" /><span>Итого</span>
                <div class="user_name">
                    <img src="images/shop/rub.png" width="16" height="16" style="margin-top: 12px;margin-left: 17px;" />
                    <span class="rub_summa">{{ rubs }}</span>
                    <img src="images/shop/coin.png" width="16" height="16" style="margin-top: 10px;margin-left: 97px;" />
                    <span class="rub_summa" style="color: #FFCD00;">{{ bonuses }}</span>
                </div>
            </div>
            <button class="btn btn-danger" type="button" style="width: 250px;" @click="pay">Оплатить</button>
        </div>
        <div class="right">
            <div class="top"><img src="images/shop/2.svg" /><span style="margin-left: 14px;">Магазин</span><i class="fas fa-search lupa"></i><input @keydown="enter" v-model="product_name" class="input_shop" type="text" placeholder="Поиск товаров" /><button class="butt" type="button">Все</button><button class="butt" type="button">Товары</button><button class="butt" type="button">Пакетные предложения</button><button class="butt" type="button">Услуги</button></div>
            <div class="bottom2" style="border-radius: 20px;padding: 30px;">
                <div class="goods" v-for="(g, index) in goods">
                    <div class="goods_img"><img :src="g.icon" height="200" /></div>
                    <div class="goods_text">
                        <div>{{ g.name }}</div><br><div>{{ g.product }} {{ g.product_param }}</div>
                    </div>
                    <div class="goods-btn">
                        <div class="goods_price">
                            <div v-if="g.price != 0"><img src="images/shop/rub.png" width="20" /><span>{{ g.price }}</span></div>
                            <div v-if="g.price_bonus != 0"><img src="images/shop/coin.png" width="20" /><span>{{ g.price_bonus }}</span></div>
                        </div>
                        <button class="goods_cart" @click="toCart(index)" type="button"><i class="fa fa-cart-plus fa-lg"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payModalLabel">Оплата</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="main2">
                        <div class="div_2">
                            <div class="div_data">
                                <div class="div_3">
                                    <div>
                                        <div class="div_4"><input id="formcheck_1" class="formcheck_1" name="pay" type="radio" checked /><label class="form-label" for="formcheck_1">Наличные</label></div>
                                        <div class="div_4"><input id="formcheck_2" class="formcheck_1" name="pay" type="radio" /><label class="form-label" for="formcheck_2">Карта</label></div>
                                    </div>
                                </div>
                                <div class="div_3">
                                    <div>
                                        <div class="div_4"><input id="formcheck_3" class="formcheck_1" type="checkbox" /><label class="form-label" for="formcheck_3">Отправить на почту</label></div>
                                        <div class="div_4"><input id="formcheck_4" class="formcheck_1" type="checkbox" /><label class="form-label" for="formcheck_4">Печать</label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div_7" style="border-style: none;">
                            <div class="bottom"><span class="span_1">Комментарий к платежу</span><input class="div_6" type="text" /></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save" @click="payJson">Оплата</button>
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
            goods: [],
            product_name: '',
            cart: [],
            cartElement: {},
            rubs: 0,
            bonuses: 0,
            findClient: {},
            modal: null,
            clients: [],
            filteredClients: [],
            searchQuery: '',
            findWindow: false
        }
    },
    methods: {
        pay() {
            this.modal.show();
        },
        payJson() {
            console.log(JSON.stringify(this.cart));
            this.modal.hide();
            this.cart = [];
        },
        clearClient() {
            this.findClient = {};
            this.client = '';
        },
        searchClientToKey(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        searchClients() {
            this.filteredClients = this.clients.filter(client => {
                this.findWindow = this.filteredClients.length > 1;
                if (this.searchQuery.length < 2) this.findWindow = false;
                return client.login.toLowerCase().includes(this.searchQuery.toLowerCase())
            });

        },
        handleClickOutside(event) {
            if (!this.$refs.findBlock.contains(event.target)) {
                this.findWindow = false
            }
        },
        selectFindClient(i) {
            this.searchQuery = this.filteredClients[i].login;
            setTimeout(function (){
                this.search();
            }.bind(this),200);
        },
        async getClients() {
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

            var response = await fetch("api/client/all", requestOptions);
            this.clients = await response.json();
        },
        async search() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("login", this.searchQuery);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/shop/find/client", requestOptions);
            this.findWindow = false;
            try {
                var result = await response.json();
                this.findClient = result;
            }
            catch (e) {
                result = null;
            }
            if (result === null) {
                alert('Клиент не найден');
                this.findClient = {};
            }
        },
        del(i) {
            this.cart.splice(i,1);
            this.calcSum();
        },
        calcSum() {
            this.rubs = 0;
            this.bonuses = 0;
            this.cart.forEach(function (item, index) {
                this.rubs += item.price * item.qty;
                this.bonuses += item.price_bonus * item.qty;
            }.bind(this))
        },
        toCart(i) {
            var name = this.goods[i].product + ' ' + this.goods[i].product_param;
            var dublicat = false;
            this.cart.forEach(function (item, i) {
                if (item.name === name) {
                    this.cart[i].qty++;
                    dublicat = true;
                }
            }.bind(this));
            if (!dublicat) {
                this.cartElement.name = name;
                this.cartElement.id = this.goods[i].storeid;
                if (this.goods[i].price != 0) {
                    this.cartElement.price = Number(this.goods[i].price);
                    this.cartElement.price_bonus = 0;
                }
                else {
                    this.cartElement.price_bonus = Number(this.goods[i].price_bonus);
                    this.cartElement.price = 0;
                }
                this.cartElement.qty = 1;
                this.cart.push(this.cartElement);
                this.cartElement = {};
            }
            this.calcSum();
        },
        enter(e) {
            if (e.keyCode === 13) {
                this.find();
            }
        },
        async find() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("search", this.product_name);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/shop/find", requestOptions);
            this.goods = await response.json();
        },
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
            var result = await response.json();
            this.goods = result[0];
        }
    },
    mounted() {
        var payModal = document.getElementById('payModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(payModal);

        this.getAll();
        this.getClients();
    }
}
</script>

<style scoped>

.client_login {
    display: inline-block;
    margin-top: 3px;
    margin-left: -147px;
    position: relative;
    top: 35px;
}
.modal-footer {
    justify-content: flex-start;
}
.popup {
    width: 250px;
    background: var(--light-blue-bg-color);
    position: absolute;
    top: 216px;
    left: 127px;
    border-radius: 10px;
}
ul li {
    list-style-type: none;
    cursor: pointer;
}
.bottom2 {
    overflow: auto;
    max-height: 861px;
    justify-content: space-between;
}
.save {
    background: var(--disable);
    border: none;
    margin-left: 20px;
}

.div_2 {
    height: 150px;
    display: flex;
    color: var(--standart-gray);
    border-bottom-width: 1px;
    border-bottom-style: solid;
    border-color: #172d39;
    flex-direction: column;
}

.div_3 {
    width: 499px;
    height: 158px;
    display: flex;
    padding: 31px;
    padding-top: 0;
}

.div_7 {
    width: 500px;
    height: 102px;
    display: flex;
    padding: 31px;
    padding-top: 0;
    flex-direction: column;
}

.div_4 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 23px;
    color: var(--standart-gray);
    border: none;
    padding-top: 2px;
    width: 190px;
    border-radius: 8px;
}

.div_6 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 6px;
    color: var(--standart-gray);
    border: none;
    padding-top: 2px;
    width: 444px;
    border-radius: 8px;
}

.check-1 + label {
    display: inline-flex;
    align-items: center;
    user-select: none;
}

.check-1 + label::after {
    content: '';
    display: inline-block;
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #adb5bd;
    border-radius: 0.25em;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
    left: 186px;
    position: absolute;
}

.check-1:checked + label::after {
    border-color: #0b76ef;
    background-color: #0b76ef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.check-2 + label {
    display: inline-flex;
    align-items: center;
    user-select: none;
}

.check-2 + label::after {
    content: '';
    display: inline-block;
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #adb5bd;
    border-radius: 0.25em;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
    left: 416px;
    position: absolute;
}

.check-2:checked + label::after {
    border-color: #0b76ef;
    background-color: #0b76ef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.span_1 {
    margin-top: 14px;
    display: inline-block;
    font-size: 11px;
    color: var(--standart-gray);
}

.div_data {
    display: flex;
    font-size: 13px;
}

.bottom {
    height: 92px;
    display: flex;
    flex-direction: column;
}

.btn {
}

.formcheck_1 {
    position: absolute;
    z-index: -1;
    opacity: 0;
}
.main2 {
    width: 500px;
    height: 255px;
}
.modal-body {
    padding: 0;
}
.content {
    background: var(--dark-green-b);
    color: var(--standart-gray);
}
.formcheck_1 + label::before {
    content: '';
    display: inline-block;
    width: 1em;
    height: 1em;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #adb5bd;
    border-radius: 0.25em;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
}

.formcheck_1:checked + label::before {
    border-color: #0b76ef;
    background-color: #0b76ef;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}

.formcheck_1 + label::before {
    position: relative;
    left: 161px;
    top: 2px;
}

.formcheck_1 + label {
    position: relative;
    left: -23px;
    top: 5px;
}

/* стили при наведении курсора на checkbox */

.formcheck_1:not(:disabled):not(:checked) + label:hover::before {
    border-color: #b3d7ff;
}

/* стили для активного состояния чекбокса (при нажатии на него) */

.formcheck_1:not(:disabled):active + label::before {
    background-color: #b3d7ff;
    border-color: #b3d7ff;
}

/* стили для чекбокса, находящегося в фокусе */

.formcheck_1:focus + label::before {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* стили для чекбокса, находящегося в фокусе и не находящегося в состоянии checked */

.formcheck_1:focus:not(:checked) + label::before {
    border-color: #80bdff;
}

/* стили для чекбокса, находящегося в состоянии disabled */

.formcheck_1:disabled + label::before {
    background-color: #e9ecef;
}
.main {
    width: 1790px;
    height: 945px;
    display: flex;
    color: white;
    margin-left: 13px;
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
    top: 31px;
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
    margin-right: 25px;
    margin-bottom: 28px;
    display: inline-block;
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
