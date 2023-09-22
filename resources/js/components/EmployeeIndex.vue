<template>
<div>
    <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config">
    </vue-bootstrap4-table>
</div>
</template>

<script>
import { defineComponent } from 'vue'
import VueBootstrap4Table from 'vue-bootstrap4-table'

export default defineComponent({
    props: ['employeeList'],
    components: {
        VueBootstrap4Table
    },
    beforeMount() {
        console.log(this.$props.employeeList)
    },
    data: function() {
        return {
            rows: [{
                    "id": 1,
                    "name": {
                        "first_name": "Vladimir",
                        "last_name": "Nitzsche"
                    },
                    "address": {
                        "country": "Mayotte"
                    },
                    "email": "franecki.anastasia@gmail.com",
                },
                {
                    "id": 2,
                    "name": {
                        "first_name": "Irwin",
                        "last_name": "Bayer"
                    },
                    "age": 23,
                    "address": {
                        "country": "Guernsey"
                    },
                    "email": "rlittle@macejkovic.biz",
                },
                {
                    "id": 3,
                    "name": {
                        "first_name": "Don",
                        "last_name": "Herman"
                    },
                    "address": {
                        "country": "Papua New Guinea"
                    },
                    "email": "delia.becker@cormier.com",
                }],
            columns: [{
                    label: "id",
                    name: "id",
                    filter: {
                        type: "simple",
                        placeholder: "id"
                    },
                    sort: true,
                },
                {
                    label: "First Name",
                    name: "name.first_name",
                    filter: {
                        type: "simple",
                        placeholder: "Enter first name"
                    },
                    sort: true,
                },
                {
                    label: "Last Name",
                    name: "name.last_name",
                    filter: {
                        type: "simple",
                        placeholder: "Enter first name"
                    },
                    sort: true,
                },
                {
                    label: "Email",
                    name: "email",
                    sort: true,
                },
                {
                    label: "Country",
                    name: "address.country",
                    filter: {
                        type: "simple",
                        placeholder: "Enter country"
                    },
                }],
            config: {
                checkbox_rows: true,
                rows_selectable: true,
                card_title: "Vue Bootsrap 4 advanced table"
            }
        }
    }
})
</script>