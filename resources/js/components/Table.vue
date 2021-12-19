<template>
    <div>
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Country</th>
                    <th scope="col">Author</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <th scope="row">{{ user.id }}</th>

                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.mobile }}</td>
                    <td>{{ user.country }}</td>
                    <td>{{ user.author == 0 ? "No" : "Yes" }}</td>
                    <td>{{ user.status == 0 ? "non-active" : "active" }}</td>
                    <td>{{ moment(user.created_at).format("DD-MM-YYYY") }}</td>
                    <td>{{ moment(user.updated_at).format("DD-MM-YYYY") }}</td>
                    <td>
                        <div class="d-flex">
                            <button
                                type="button"
                                @click="editUser(user.id)"
                                class="btn btn-outline-warning me-3"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                            >
                                <i class="far fa-edit"></i>
                            </button>
                            <a
                                class="btn btn-outline-danger me-3"
                                href="#"
                                role="button"
                                @click="deleteUser(user.id)"
                                ><i class="fas fa-trash-alt"></i
                            ></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            users: [],
            id: null,
            moment: moment,
        };
    },
    methods: {
        editUser(id) {
            this.$emit("Edit", id);
        },
        deleteUser(id) {
            this.$emit("delete", id);
        },
    },
    created() {
        this.axios
            .get("http://localhost:8000/api/users/")
            .then((response) => {
                this.users = response.data;
            })
            .catch((err) => console.log(err));
    },
};
</script>
<style scoped>
.btn:focus,
.btn:active.focus {
    box-shadow: none;
}
input[type="text"]:focus,
input[type="email"]:focus,
input[type="search"]:focus,
.form-select:focus,
input[type="number"]:focus {
    border-color: rgba(82, 168, 236, 0.8);
    outline: 0;
    outline: thin dotted \9;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}
</style>
