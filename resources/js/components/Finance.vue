<template>
    <div class="home">
        <table>
            <thead>
                <tr>
                    <th>Имя сотрудника</th>
                    <th>Номер смены</th>
                    <th>Начало смены</th>
                    <th>Конец смены</th>
                    <th>Наличными</th>
                    <th>Кол-во операций</th>
                    <th>Безнал</th>
                    <th>Кол-во операций</th>
                    <th>Возврат нал</th>
                    <th>Кол-во операций</th>
                    <th>Возврат безнал</th>
                    <th>Кол-во операций</th>
                    <th>Бонусами</th>
                    <th>Кол-во операций</th>
                    <th>Статус</th>
                    <th>Нал продажи</th>
                    <th>Кол-во операций</th>
                    <th>Безнал продажи</th>
                    <th>Кол-во операций</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="f in finance">
                <td>{{ f.admin_name }}</td>
                <td>{{ f.shift }}</td>
                <td>{{ f.open_shift }}</td>
                <td>{{ f.close_shift }}</td>
                <td>{{ f.cash }}</td>
                <td>{{ f.cash_num }}</td>
                <td>{{ f.nocash }}</td>
                <td>{{ f.nocash_num }}</td>
                <td>{{ f.return_cash }}</td>
                <td>{{ f.return_cash_num }}</td>
                <td>{{ f.return_nocash }}</td>
                <td>{{ f.return_nocash_num }}</td>
                <td>{{ f.bonus }}</td>
                <td>{{ f.bonus_num }}</td>
                <td>{{ f.status }}</td>
                <td>{{ f.shop_cash }}</td>
                <td>{{ f.shop_cash_num }}</td>
                <td>{{ f.shop_nocash }}</td>
                <td>{{ f.shop_nocash_num }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            finance: []
        }
    },
    methods: {
        enter(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        async getAllFinance() {
            var urlencoded = new URLSearchParams();

            var requestOptions = {
                method: 'POST',
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/getAllFinance", requestOptions);
            var result = await response.json();
            console.log(result);
            this.finance = result;
        }
    },
    mounted() {
        this.getAllFinance();
    }
}
</script>

<style scoped>
.home {
    width: 1795px;
    margin-left: 11px;
}
.home table{
    width: 100%;
    color: white;
    background: var(--light-blue-bg-color);
    padding: 5px;
    font-size: 11px;
    border-radius: 10px;
}
.home table thead tr th {
    padding: 8px;
}
.home table tr td {
    padding: 8px;
}
</style>
