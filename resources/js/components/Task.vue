<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left">
                <i class="fa fa-info-circle"></i>
                <span>История задач</span>
            </div>
            <button class="btn btn-success" type="button" @click="addTask">Новая задача +</button>
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
                            <td class="status_column">
                                <div class="status" style="background: green">Новый</div>
                            </td>
                            <td>{{ c.descript_admin }}</td>
                            <td>{{ c.create_dt }}</td>
                            <td>{{ c.end_dt }}</td>
                            <td>{{ c.name }}</td>
                            <td>{{ c.employ }}</td>
                            <td class="status_column">
                                <div :style="{background: c.color}" class="status" @click="showModalStatus(i)">{{ c.description }}</div>
                            </td>
                            <td style="border-right-style: none;color: green">
                                <button class="btn btn-success me-2" @click="editTask(i)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-success"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Добавить -->
    <div id="addTaskModal" aria-hidden="true" aria-labelledby="addTaskModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addTaskModalLabel" class="modal-title">Добавить задание</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body" style="padding: 17px;">
                    <div class="block" style="margin-top: 0">
                        <span>Описание</span>
                        <input v-model="descript_admin" class="input" placeholder="Протереть столы" type="text"/>
                    </div>
                    <div class="block">
                        <span>Плановая дата публикации задания</span>
                        <input id="start" v-model="datePublic" class="input" type="text" @click="calendarShowStart"/>
                    </div>
                    <div class="block">
                        <span>Срок выполнения</span>
                        <select v-model="days" class="input">
                            <option v-for="(d,i) in deadLineDay" :value="d">{{ d }} дн.</option>
                        </select>
                        <select v-model="hours" class="input">
                            <option v-for="(d,i) in deadLineHours" :value="d">{{ d }} ч.</option>
                        </select>
                    </div>
                    <div class="block">
                        <span>Исполнитель</span>
                        <select v-model="executor" class="input">
                            <optgroup label="Выберите исполнителя">
                                <option v-for="u in users" :value="u.id">{{ u.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="saveAddModal">Сохранить</button>
                </div>
            </div>
        </div>
        <calendar ref="calandarStart" style:="position: absolute" @item-selected="calendarSelectStart"></calendar>
    </div>

    <!-- Модальное окно Изменить -->
    <div id="editTaskModal" aria-hidden="true" aria-labelledby="addTaskModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="addTaskModalLabel" class="modal-title">Изменить задание</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body" style="padding: 17px;">
                    <div class="block" style="margin-top: 0">
                        <span>Описание</span>
                        <input v-model="descript_admin" class="input" placeholder="Протереть столы" type="text"/>
                    </div>
                    <div class="block">
                        <span>Плановая дата публикации задания</span>
                        <input id="start" v-model="datePublic" class="input" type="text" @click="calendarShowStart"/>
                    </div>
                    <div class="block">
                        <span>Срок выполнения</span>
                        <select v-model="days" class="input">
                            <option v-for="(d,i) in deadLineDay" :value="d">{{ d }} дн.</option>
                        </select>
                        <select v-model="hours" class="input">
                            <option v-for="(d,i) in deadLineHours" :value="d">{{ d }} ч.</option>
                        </select>
                    </div>
                    <div class="block">
                        <span>Исполнитель</span>
                        <select v-model="executor" class="input">
                            <optgroup label="Выберите исполнителя">
                                <option v-for="u in users" :value="u.id">{{ u.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="saveEditTask">Сохранить</button>
                </div>
            </div>
        </div>
        <calendar ref="calandarStart" style:="position: absolute" @item-selected="calendarSelectStart"></calendar>
    </div>

    <!-- Модальное окно -->
    <div id="changeStatusModal" aria-hidden="true" aria-labelledby="changeStatusModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="changeStatusModalLabel" class="modal-title">Смена статуса</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body" style="padding-left: 15px;">
                    <span>Перевести текущее задание в статус: {{ newStatus.description }}</span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="saveNewStatus">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>

</template>

<script>
import {createLog} from '../logger';

export default {
    name : "Task",
    props: ['club_id', 'tasks', 'admin_id'],
    data() {
        return {
            tasks         : [],
            modal         : null,
            modalStatus   : null,
            users         : [],
            deadLineDay   : [],
            deadLineHours : [],
            editTaskModal : null,
            days          : 0,
            hours         : 0,
            executor      : '',
            descript_admin: '',
            datePublic    : '',
            id_task       : 0,
            newStatus     : '',

        }
    },
    methods: {
        editTask(i) {
            this.descript_admin = this.tasks[i].descript_admin;
            this.datePublic     = this.tasks[i].create_dt;
            var executor_id     = this.tasks[i].executor_id;
            this.users.forEach((item, index) => {
                if (item.id == executor_id) {
                    this.executor = item.id;
                }
            });
            this.id_task = this.tasks[i].id;
            this.editTaskModal.show();
        },
        async saveEditTask() {
            this.editTaskModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id_task", this.id_task);
            urlencoded.append("date_public", this.datePublic);
            urlencoded.append("days", this.days);
            urlencoded.append("hours", this.hours);
            urlencoded.append("executor", this.executor);
            urlencoded.append("club_id", this.club_id);
            urlencoded.append("admin_id", this.$props.admin_id);
            urlencoded.append("descript_admin", this.descript_admin);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/save/edit", requestOptions);
            if (response.ok) {
                this.getTasks();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getTasks() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.club_id);
            urlencoded.append("admin_id", this.$props.admin_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/get", requestOptions);
            if (response.ok) {
                this.tasks = await response.json();
            }
        },
        async saveNewStatus() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("id", this.newStatus.id_task);
            urlencoded.append("id_desk", this.newStatus.id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/save-new-status", requestOptions);
            if (response.ok) {
                var result = await response.json();
                this.modalStatus.hide();
                this.alltasks();
            } else {
                this.$refs.message.modal.show();
            }
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
                    method  : 'POST',
                    headers : myHeaders,
                    body    : urlencoded,
                    redirect: 'follow'
                };

                var response = await fetch("api/tasks/new-status", requestOptions);
                if (response.ok) {
                    this.newStatus         = await response.json();
                    this.newStatus.id_task = this.tasks[i].id;
                    this.modalStatus.show();
                } else {
                    this.$refs.message.modal.show();
                }
            }
        },
        addTask() {
            this.descript_admin = '';
            this.datePublic     = '';
            this.days           = '';
            this.hours          = '';
            this.executor       = null;
            this.modal.show();
        },
        async saveAddModal() {
            this.modal.hide();
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
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/save", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            } else {
                var r = await response.json();
                this.alltasks();
            }
        },
        async getUsers() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");
            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/users", requestOptions);
            if (response.ok) {
                this.users = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async alltasks() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("admin_id", this.$props.admin_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/tasks/all", requestOptions);
            if (response.ok) {
                this.tasks = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        calendarShowStart(e) {
            this.$refs.calandarStart.top  = e.pageY;
            this.$refs.calandarStart.left = e.pageX;
            this.$refs.calandarStart.show();
        },
        calendarSelectStart() {
            var day         = this.$refs.calandarStart.selectedDay;
            var month       = this.$refs.calandarStart.currentMonth + 1;
            var year        = this.$refs.calandarStart.currentYear;
            var date        = new Date(year, month - 1, day);
            this.datePublic = formatDate(date);
            this.$refs.calandarStart.hide();
        },
        calendarHideStart() {
            this.$refs.calandarStart.hide();
        },
    },
    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', function (e) {
                this.$refs.calandarStart.top  = e.pageY;
                this.$refs.calandarStart.left = e.pageX;
            }.bind(this));
        });
        this.getUsers();
        this.tasks       = JSON.parse(this.$props.tasks);
        var addTaskModal = document.getElementById('addTaskModal')
        this.modal       = bootstrap.Modal.getOrCreateInstance(addTaskModal);

        var editTaskModal  = document.getElementById('editTaskModal')
        this.editTaskModal = bootstrap.Modal.getOrCreateInstance(editTaskModal);

        var changeStatusModal = document.getElementById('changeStatusModal')
        this.modalStatus      = bootstrap.Modal.getOrCreateInstance(changeStatusModal);

        let i = 1;
        for (i = 1; i <= 7; i++) {
            this.deadLineDay.push(i);
        }
        i = 1;
        for (i = 1; i <= 24; i++) {
            this.deadLineHours.push(i);
        }
    }
}
</script>

<style scoped>
.bt {
    border-radius : 5px 30px 5px 30px;
    font-size     : inherit;
}

.block {
    display        : flex;
    flex-direction : column;
    align-items    : flex-start;
    margin-top     : 20px;
}

.input {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 6px;
    color         : var(--standart-gray);
    border        : none;
    padding-top   : 2px;
    width         : 465px;
    border-radius : 8px;
}

.modal-content {
    background : var(--light-blue-bg-color);
    color      : var(--standart-gray);
}

.modal-footer {
    justify-content : flex-start;
}

.status_column {
    display         : flex;
    flex-direction  : row;
    width           : 100% !important;
    justify-content : center;
}

.status {
    width           : 180px;
    height          : 40px;
    border-radius   : 5px;
    display         : flex;
    align-items     : center;
    justify-content : center;
    cursor          : pointer;
}

.scroll_table {
    overflow-x : auto;
    height     : 702px;
    background : var(--light-blue-bg-color);
}

.home {
    width       : 1793px;
    height      : 815px;
    color       : var(--standart-gray);
    margin-left : 11px;
}

.home .header_bottom .header_bottom_left {
    display     : flex;
    align-items : center;
    gap         : 10px;
}

.home .header_bottom {
    display         : flex;
    justify-content : space-between;
    align-items     : center;
}

.home .header_bottom {
    display     : flex;
    align-items : center;
    gap         : 10px;
}

.main_table {
    height : 885px;
}

.home table {
    width         : 100%;
    color         : var(--standart-gray);
    padding       : 5px;
    border-radius : 10px;
}

.home table th {
    width : 12.5%;
}

.home td {
    width : 12.5%;
}

.home thead {
    background    : var(--light-blue-bg-color);
    border-radius : 10px;
}

.t2 {
    margin-top    : 13px;
    border-radius : 15px;
    overflow      : hidden;
}

.t1 th:not(:last-child) {
    padding            : 10px;
    border-right-width : 1px;
    border-right-style : solid;
    text-align         : center;
    border-color       : #4d4d4d;
    font-weight        : normal;
}

.t2 td:not(:last-child) {
    padding            : 10px;
    border-right-width : 1px;
    border-right-style : solid;
    text-align         : center;
    border-color       : #4d4d4d;
}

.t1 {
    border-radius : 15px;
    overflow      : hidden;
}
</style>
