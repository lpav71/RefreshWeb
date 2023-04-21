<template>
    <div class="home">
        <div class="header_bottom">
            <div class="header_bottom_left"><i class="fas fa-info-circle"></i><span>История задач</span></div>
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
                        <tr v-for="c in tasks">
                            <td class="status_column"><div class="status" style="background: green">Новый</div></td>
                            <td>{{ c.descript_admin }}</td>
                            <td>{{ c.create_dt }}</td>
                            <td>{{ c.end_dt }}</td>
                            <td>{{ c.name }}</td>
                            <td></td>
                            <td class="status_column"><div class="status" :style="{background: c.color}">{{ c.description }}</div></td>
                            <td style="border-right-style: none;color: green"><button class="btn btn-success"><i class="far fa-edit"></i></button><button class="btn btn-success"><i class="fas fa-times"></i></button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Task",
    props: ['club_id', 'tasks'],
    data() {
        return {
            tasks: []
        }
    },
    methods: {

    },
    mounted() {
        this.tasks = JSON.parse(this.$props.tasks);
    }
}
</script>

<style scoped>
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
