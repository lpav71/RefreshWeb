<template>
<div class="home">
    <div class="header">
        <div class="left">
            <div class="top"><img src="img/4.svg" alt=""/><span style="margin-left: 14px;">Платежный терминал</span></div>
            <button @click="editModal" class="butt" type="button">Автопоиск ККТ</button>
        </div>
    </div>
    <div class="bottom">
        <div>
            <span class="span-1">Тип ПТ</span>
            <select v-model="appType" class="div_4">
                <option v-for="t in 3">Value</option>
            </select>
        </div>
        <div>
            <span class="span-1">Путь к дистрибутиву ПТ</span>
            <select v-model="appType" class="div_4">
                <option v-for="t in 3">Value</option>
            </select>
        </div>
        <div>
            <span class="span-1">Тип соединения</span>
            <select v-model="appType" class="div_4">
                <option v-for="t in 3">Value</option>
            </select>
        </div>
        <div>
            <span class="span-1">Порт</span>
            <select v-model="appType" class="div_4">
                <option v-for="t in 3">Value</option>
            </select>
        </div>
        <div>
            <span class="span-1">Скорость соединения</span>
            <select v-model="appType" class="div_4">
                <option v-for="t in 3">Value</option>
            </select>
        </div>
        <button class="btn butt1" type="button">Сохранить</button>
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
.span-1 {
    margin-top: 14px;
    display: block;
    font-size: inherit;
}
.div_4 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 1px;
    color: var(--standart-gray);
    border: none;
    width: 190px;
    border-radius: 8px;
    font-size: inherit;
}
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
.home .header {
    width: 516px;
    display: flex;
    justify-content: start;
}
.bottom {
    width: 1793px;
    height: 855px;
    background: var(--light-blue-bg-color);
    margin-top: 10px;
    border-radius: 20px;
    padding: 20px;
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
    display: inline-block;
}
.butt1 {
    background: var(--disable);
    border: none;
    height: 42px;
    margin-top: 20px;
    min-width: 94px;
    padding-right: 20px;
    padding-left: 20px;
    display: inline-block;
    border-radius: 5px;
}
.top {
    width: 235px;
    height: 42px;
    display: inline-block;
}
</style>
