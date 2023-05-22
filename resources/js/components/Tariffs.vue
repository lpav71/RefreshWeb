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

            <div class="tariff-name">Поминутный</div>
            <div class="t0">
                <div class="goods" v-for="(g, index) in tariffs0">
                    <div class="goods_img"><img :src="g.icon" height="200" alt=""></div>
                    <div class="goods_text">
                        <div>{{ g.time_start }} {{ g.time_stop }}</div><br><div>{{ g.price }}р/мин</div>
                    </div>
                    <div class="goods-btn">
                        <span>{{ g.name }}</span>
                        <button class="goods_cart" @click="editModal(index)" type="button"><i class="fa fa-edit fa-lg"></i></button>
                    </div>
                </div>
            </div>

            <div class="tariff-name">Пакетное предложение</div>
            <div class="t1">
                <div class="goods" v-for="(g, index) in tariffs1">
                    <div class="goods_img"><img :src="g.icon" height="200" alt=""></div>
                    <div class="goods_text">
                        <div>{{ g.time_start }} {{ g.time_stop }}</div><br><div>{{ g.price }}р/мин</div>
                    </div>
                    <div class="goods-btn">
                        <span>{{ g.name }}</span>
                        <button class="goods_cart" @click="editModal(index)" type="button"><i class="fa fa-edit fa-lg"></i></button>
                    </div>
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
            tariffs0: {},
            tariffs1: {}
        }
    },
    methods: {
       async get0() {
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

           var response = await fetch("api/price/get0", requestOptions);
           this.tariffs0 = await response.json();
       },
        async get1() {
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

            var response = await fetch("api/price/get1", requestOptions);
            this.tariffs1 = await response.json();
        }
    },
    mounted() {
        this.get0();
        this.get1();
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
.t0, .t1 {
    display: flex;
}
.tariff-name {
    padding: 20px 0 20px 0;
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
    flex-direction: column;
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
