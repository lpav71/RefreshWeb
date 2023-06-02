<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left"><i class="fas fa-info-circle"></i><span>История задач</span></div><button type="button" class="btn btn-success bt" @click="addTask">Новая задача +</button>
        </div>
        <div class="main_table" style="margin-top: 20px;">
            <div class="t1">
                <table>
                    <thead>
                    <tr>
                        <th>Акт</th>
                        <th>Задача</th>
                        <th>Дата</th>
                        <th>Срок выполнения</th>
                        <th>Поручил</th>
                        <th>Исполнитель</th>
                        <th>Статус</th>
                        <th>Операции</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="t2">
                <div class="scroll_table">
                    <table>
                        <tbody>
                        <tr v-for="(c, i) in tasks">
                            <td class="status_column"><div class="status" style="background: green">Новый</div></td>
                            <td>{{ c.descript_admin }}</td>
                            <td>{{ c.create_dt }}</td>
                            <td>{{ c.end_dt }}</td>
                            <td>{{ c.name }}</td>
                            <td>{{ c.employ }}</td>
                            <td class="status_column"><div class="status" :style="{background: c.color}" @click="showModalStatus(i)">{{ c.description }}</div></td>
                            <td style="border-right-style: none;color: green"><button class="btn btn-success"><i class="far fa-edit"></i></button><button class="btn btn-success"><i class="fas fa-times"></i></button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Добавить задание</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body" style="padding: 17px;">
                    <div class="block" style="margin-top: 0">
                        <span>Описание</span>
                        <input type="text" class="input" placeholder="Протереть столы" v-model="descript_admin" />
                    </div>
                    <div class="block">
                        <span>Плановая дата публикации задания</span>
                        <input type="datetime-local" class="input" v-model="datePublic" />
                    </div>
                    <div class="block">
                        <span>Срок выполнения</span>
                        <select class="input" v-model="days">
                                <option v-for="(d,i) in deadLineDay" :value="d">{{ d }} дн.</option>
                        </select>
                        <select class="input" v-model="hours">
                            <option v-for="(d,i) in deadLineHours" :value="d">{{ d }} ч.</option>
                        </select>
                    </div>
                    <div class="block">
                        <span>Исполнитель</span>
                        <select class="input" v-model="executor">
                            <optgroup label="Выберите исполнителя">
                                <option v-for="u in users" :value="u.id">{{ u.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="saveAddModal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Смена статуса</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body" style="padding-left: 15px;">
                    <span>Перевести текущее задание в статус: {{ newStatus.description }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="saveNewStatus">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "Task",
    props: ['club_id', 'tasks', 'admin_id'],
    data() {
        return {
            tasks: [],
            modal: null,
            modalStatus: null,
            users: [],
            deadLineDay: [],
            deadLineHours: [],
            days: 0,
            hours: 0,
            executor: '',
            descript_admin: '',
            datePublic: '',
            newStatus : ''
        }
    },
    methods: {
        async saveNewStatus() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", this.newStatus.id_task);
            urlencoded.append("id_desk", this.newStatus.id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/save-new-status", requestOptions);
            var result = await response.json();
            this.modalStatus.hide();
            this.alltasks();
        },
        async showModalStatus(i) {
            var idTaskDesc = this.tasks[i].id_desk;
            if (idTaskDesc < 4) {
                var newStatus = ++idTaskDesc;

                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("id", newStatus);

                var requestOptions = {
                    method: 'POST',
                    headers: myHeaders,
                    body: urlencoded,
                    redirect: 'follow'
                };

                var response = await fetch("api/tasks/new-status", requestOptions);
                this.newStatus = await response.json();
                this.newStatus.id_task = this.tasks[i].id;
                this.modalStatus.show();
            }
        },
        addTask() {
            this.getUsers();
            this.modal.show();
        },
        async saveAddModal() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");
            var urlencoded = new URLSearchParams();
            urlencoded.append("descript_admin", this.descript_admin);
            urlencoded.append("date_public", this.datePublic);
            urlencoded.append("days", this.days);
            urlencoded.append("hours", this.hours);
            urlencoded.append("executor", this.executor);
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("admin_id", this.$props.admin_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/save", requestOptions);
            var r = await response.json();
            this.modal.hide();
            this.alltasks();
        },
        async getUsers() {
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

            var response = await fetch("api/tasks/users", requestOptions);
            this.users = await response.json();
        },
        async alltasks() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("admin_id", this.$props.admin_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/all", requestOptions);
            this.tasks = await response.json();
        }
    },
    mounted() {
        this.tasks = JSON.parse(this.$props.tasks);
        var addTaskModal = document.getElementById('addTaskModal')
        this.modal = bootstrap.Modal.getOrCreateInstance(addTaskModal);

        var changeStatusModal = document.getElementById('changeStatusModal')
        this.modalStatus = bootstrap.Modal.getOrCreateInstance(changeStatusModal);

        let i=1;
        for (i = 1; i <= 7; i++) {
            this.deadLineDay.push(i);
        }
        i=1;
        for (i = 1; i <= 24; i++) {
            this.deadLineHours.push(i);
        }
    }
}
</script>

<style scoped>
.bt {
    border-radius: 5px 30px 5px 30px;
    font-size: inherit;
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
.modal-content {
    background: var(--light-blue-bg-color);
    color: var(--standart-gray);
}
.modal-footer {
    justify-content: flex-start;
}
.btn {
    color: var(--standart-gray);
    margin-right: 10px;
}
.status_column {
    display: flex;
    flex-direction: row;
    width: 100% !important;
    justify-content: center;
}
.status {
    width: 180px;
    height: 40px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
.scroll_table {
    overflow-x: auto;
    height: 850px;
    background: var(--light-blue-bg-color);
}
.home {
    width: 1793px;
    height: 947px;
    color: var(--standart-gray);
    margin-left: 11px;
}

.home .header_bottom .header_bottom_left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.home .header_bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.home .header_bottom {
    display: flex;
    align-items: center;
    gap: 10px;
}

.main_table {
    height: 885px;
}

.home table {
    width: 100%;
    color: var(--standart-gray);
    padding: 5px;
    font-size: 11px;
    border-radius: 10px;
}

.home table th {
    width: 12.5%;
    font-size: 16px;
}

.home td {
    width: 12.5%;
    font-size: 18px;
}

.home thead {
    background: var(--light-blue-bg-color);
    border-radius: 10px;
}

.t2 {
    margin-top: 13px;
    border-radius: 15px;
    overflow: hidden;
}

.t1 th {
    padding: 10px;
    border-right-width: 1px;
    border-right-style: solid;
    text-align: center;
    border-color: #4d4d4d;
}

.t2 td {
    padding: 10px;
    border-right-width: 1px;
    border-right-style: solid;
    text-align: center;
    border-color: #4d4d4d;
}

.t1 {
    border-radius: 15px;
    overflow: hidden;
}
</style>
