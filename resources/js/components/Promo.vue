<template>
<div class="main">
    <div class="top">
        <i class="fas fa-dice-d20"></i><span>Промокоды</span>
    </div>
    <div class="bottom">
        <div class="left-right">
            <label>Введите промокод<br><input v-model="promocode" class="input_text" type="text" placeholder="Введите промокод"><a class="gen" @click="autoGen" href="">Сгенирировать автоматически</a></label>
            <label>Начало действия промокода<br><input v-model="data_start" class="input_text" type="date"></label>
            <label>Окончание действия промокода<br><input v-model="data_stop" class="input_text" type="date"></label>
            <label>Ограничение активаций<br><input v-model="num" class="input_text" type="text" placeholder="Введите количество"></label>
            <label>Комментарий<br><textarea v-model="comment" spellcheck="false" class="input_text area" type="text" placeholder="Опишите мотив промокода"></textarea></label>
            <button class="btn btn-success" @click="save">Создать</button>
        </div>
        <div class="left-right ">
            <div class="right-block">
                <span>Список промокодов</span><br>
                <div class="promocods">
                    <table>
                        <thead>
                        <tr>
                            <th>Промокод</th>
                            <th>Период действия</th>
                            <th>Комментарий</th>
                            <th>Количество активаций</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tr v-for="p in promocodes">
                            <td>{{ p.promo }}</td>
                            <td>{{ p.date_start }} - {{ p.date_stop }}</td>
                            <td>{{ p.description }}</td>
                            <td>{{ p.num }}</td>
                            <td :style="{ color: p.status_color }">{{ p.status_active }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['club_id', 'promocodes'],
    data() {
        return {
            promocodes: [],
            promocode: '',
            data_start: '',
            data_stop: '',
            num: 0,
            comment: ''
        }
    },
    methods: {
        autoGen(e) {
            e.preventDefault();
            this.promocode = (Math.random() + 1).toString(36).substring(2);
        },
        async save() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("promo", this.promocode);
            urlencoded.append("description", this.comment);
            urlencoded.append("date_start", this.data_start);
            urlencoded.append("date_stop", this.data_stop);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/promo/save", requestOptions);
            this.promocode = '';
            this.comment = '';
            this.data_start = '';
            this.data_stop = '';
            this.num = 0;
            alert('Добавлено');
            location.reload();
        }
    },
    mounted() {
        this.promocodes = JSON.parse(this.$props.promocodes);
        this.promocodes.forEach(function (item, index) {
            if (item.status == true) {
                this.promocodes[index].status_active = 'Активен';
                this.promocodes[index].status_color = 'green';
            }
            else {
                this.promocodes[index].status_active = 'Просрочен';
                this.promocodes[index].status_color = '#cc5a5a';
            }
        }.bind(this))
    }
}
</script>

<style scoped>
.btn {
    width: 130px;
    margin-top: 30px;
}
.gen {
    text-decoration: none;
    color: var(--light-green);
    margin-left: 20px;
}
.promocods {
    overflow-x: auto;
    height: 740px;
}
table {
    color: var(--standart-gray);
    font-size: 14px;
    text-align: center;
}
th {
    width: 20%;
    padding-bottom: 20px;
    padding-top: 20px;
}
td {
    padding-bottom: 10px;
    padding-top: 10px;
}
thead {
    border-bottom-width: 1px;
    border-bottom-style: solid;
}
.main {
    width: 1794px;
    height: 960px;
    margin-left: 12px;
    color: var(--standart-gray);
}
.top {
    height: 60px;
    padding-top: 14px;
}
.top span {
    display: inline-block;
    margin-left: 12px;
}
.bottom {
    height: 900px;
    background: var(--light-blue-bg-color);
    border-radius: 20px;
    display: flex;
}
.left-right {
    width: 50%;
    display: flex;
    flex-direction: column;
    padding: 10px 30px 30px 30px;
}
.left-right label {
    margin-top: 15px;
}
.input_text {
    height: 35px;
    background: var(--bg);
    padding: 5px 15px 5px 15px;
    margin-top: 10px;
    color: var(--standart-gray);
    border: none;
    width: 340px;
    border-radius: 8px;
}
.area {
    height: 100px !important;
}
.right-block {
    background: var(--bg);
    width: 100%;
    height: 100%;
    margin-top: 20px;
    border-radius: 20px;
    padding: 30px;
}
</style>
