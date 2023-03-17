<template>
    <div>
        <div class="row g-5 g-xl-8">
            <div class="col-xl-2">
            </div>
            <div class="col-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body pt-0">
                        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div v-if="product" class="table-responsive">
                                <div class="col-2 p-1">
                                    <select class="form-control" @change="changeLanguage($event)">
                                        <option value="null">select languages</option>
                                        <option v-for="item in languages" :value="item.id">{{ item.context }}</option>
                                    </select>
                                </div>
                                <table class="table align-middle table-row-dashed fs-6 gy-5 no-footer"
                                       id="kt_table_users">
                                    <thead>
                                        <tr class="text-start text-muted fw-bolder fs-7 gs-0 text-center">
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Currency</th>
                                            <th>Stock level</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-bold">
                                        <tr v-if="product">
                                            <td class="text-center">
                                                <span class="align-items-center">{{ product.id}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ product.name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ product.price }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ product.currency }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ product.stock }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ product.created_at }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a class="align-items-center pr-1" @click="openAddNewProdNameModal">Add New Name</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <add-new-product-name
            v-if="showModal"
            @close="closeAddNewProdNameModal"
            :languages="languages"
            :id="product.id"
        />

    </div>
</template>

<script>
import AddNewProductName from "./modals/AddNewProductName";
export default {
    name: "product-show",
    components: {
        AddNewProductName

    },
    data() {
        return {
            languages: null,
            showModal: false,
            visible: false,
            product: null
        }
    },
    props: ['id'],
    mounted() {
        this.getData()
        this.getLanguages()
    },
    methods: {
        getData(langId = null) {
            this.$axios.get(`products/${this.id}?lang_id=${langId}`
            ).then((res) => {
                this.product = res.data.data
            }).catch(error => {
                if (error) {
                    console.log(error)
                }
            });
        },
        getLanguages() {
            this.$axios.get('languages')
                .then(response => {
                    this.languages = response.data
                })
                .catch(error => {
                    console.log(error)
                });
        },
        changeLanguage(event) {
            let langId = event.target.value;
            this.getData(langId);
        },
        addNewProdName() {

        },
        openAddNewProdNameModal() {
            this.showModal = true;
        },
        closeAddNewProdNameModal() {
            this.showModal = false;
        }
    }
}
</script>

<style scoped>

</style>
