<template>
<div class="home">
    <div class="header">
        <div class="left">
            <div class="top"><img src="img/4.svg" alt=""/><span style="margin-left: 14px;">Тарифы и предложения</span>
            </div>
        </div>
        <div class="right">
            <button @click="editModal" class="butt" type="button">Добавить</button>
        </div>
    </div>
    <div class="bottom">
        <div class="in-bottom">
            <div class="goods" v-for="(g, index) in goods">
                <div class="goods_img"><img :src="g.icon" height="200" alt=""></div>
                <div class="goods_text">
                    <div>{{ g.name }}</div><br><div>{{ g.product }} {{ g.product_param }}</div>
                </div>
                <div class="goods-btn">
                    <span>{{ g.num }}</span>
                    <button class="goods_cart" @click="editModal(index)" type="button"><i class="fa fa-edit fa-lg"></i></button>
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
            goods: null,
            outData: null,
            modal: null,
            allowDiscount: [
                {name: 'Да', value: true},
                {name: 'Нет', value: false}
            ],
            product: {},
            product_types: {}
        }
    },
    methods: {
        enter(e) {
            if (e.keyCode === 13) {
                this.find();
            }
        },
        editModal(i) {
            this.modal.show();
            if (isNaN(i)) { // Добавить
                this.product = {};
            }
            else { //Изменить
                this.product = this.goods[i];
            }
        },
        //Добавление или изменение товара
        async addEditGoods(product) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(product);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            var response = await fetch("api/store/addedit", requestOptions);
            //var result = await response.json();
            this.getAll();
        },
        saveAddModal() {
            this.modal.hide();
            this.product.club_id = this.$props.club_id;
            this.addEditGoods(this.product);
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
            this.outData = await response.json();
            this.goods = this.outData[0];
            this.product_types = this.outData[1];
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
.modal-content {
    background: var(--light-blue-bg-color);
    color: var(--standart-gray);
}
.modal-footer {
    justify-content: flex-start;
}
.block {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 20px;
}
.input {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 6px;
    color: var(--standart-gray);
    border: none;
    padding-top: 2px;
    width: 465px;
    border-radius: 8px;
}
.bottom {
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
    max-height: 809px;
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
