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
                    <th>Операции</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="(f, index) in finance">
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
                <td>
                    <button class="btn bt" @click="finShow(index)">финансы</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="financeModal" tabindex="-1" aria-labelledby="financeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="financeModalLabel">Финансы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <thead>
                            <tr>
                                <th>Транзакция</th>
                                <th>Клиент ID</th>
                                <th>Администратор</th>
                                <th>Смена</th>
                                <th>Сумма</th>
                                <th>Тип</th>
                                <th>Дата и время</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(f, index) in financeData">
                                <td>{{ f.id }}</td>
                                <td>{{ f.user_id }}</td>
                                <td>{{ f.admin }}</td>
                                <td>{{ f.shift }}</td>
                                <td>{{ f.amount }}</td>
                                <td>{{ f.name }}</td>
                                <td>{{ f.dt_operation }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
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
            finance: [],
            modal: null,
            financeData: []
        }
    },
    methods: {
        finShow(i) {
            let shift_number = this.finance[i].shift;
            this.financeFromBD(shift_number);
            this.modal.show();
        },
        async financeFromBD(shift_num) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("shift_num", shift_num);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/data", requestOptions);
            this.financeData = await response.json();
        },
        enter(e) {
            if (e.keyCode === 13) {
                this.search();
            }
        },
        async getAllFinance() {
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method: 'POST',
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/finance/all", requestOptions);
            var result = await response.json();
            console.log(result);
            this.finance = result;
        }
    },
    mounted() {
        var financeModal = document.getElementById('financeModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(financeModal);

        this.getAllFinance();
    }
}
</script>

<style scoped lang="scss">
.home {
    width: 1795px;
    margin-left: 11px;
    table{
        width: 100%;
        color: white;
        background: var(--light-blue-bg-color);
        padding: 5px;
        font-size: 11px;
        border-radius: 10px;
        thead tr th {
            padding: 8px;
        }
        tr td {
            padding: 8px;
        }
    }
}
.modal-body {
    padding: 15px;
    table {
        width: 100%;
        padding: 5px;
        thead tr th {
            padding: 8px;
        }
        tr td {
            padding: 8px;
        }
    }
}
</style>
