<template>
    <div>
        <div class="row g-5 g-xl-8">
            <div class="col-xl-2">
            </div>
            <div class="col-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-header">
                        <el-button type="primary" plain @click="openProductCreateModal">Create product</el-button>
                    </div>
                    <div class="card-body pt-0">
                        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div v-if="products" class="table-responsive">
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
                                        <tr v-for="product in products">
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
                                                <a class="align-items-center pr-1" @click="edit(product)">Edit</a>
                                                <router-link v-bind:to="'/product/show/' + product.id">View</router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <el-pagination
                                    @current-change="handleCurrentChange"
                                    :page-size="pageParams.per_page"
                                    :current-page="pageParams.current_page"
                                    layout="prev, pager, next"
                                    :total="pageParams.total">
                                </el-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <product-create-modal
            v-if="showModal"
            @close="closeProductCreateModal"
        />

        <product-edit-modal
            v-if="showEditModal"
            @close="closeProductEditModal"
            :item="selectedProduct"
        />
    </div>
</template>

<script>
import {
    Pagination as ElPagination,
    Button as ElButton,
} from 'element-ui'
import ProductCreateModal from "./modals/ProductCreateModal";
import ProductEditModal from "./modals/ProductEditModal";

export default {
    name: "products-index",
    components: {
        ProductEditModal,
        ProductCreateModal,
        ElPagination,
        ElButton
    },
    data() {
        return {
            languages: null,
            langId: null,
            showModal: false,
            showEditModal: false,
            visible: false,
            products: null,
            selectedProduct: null,
            currentPage: null,
            pageParams: null
        }
    },
    mounted() {
        this.getData();
        this.getLanguages()
    },
    methods: {
        openProductCreateModal() {
            this.showModal = true;
        },
        closeProductCreateModal() {
            this.showModal = false;
        },
        getData(page = null, langId = null) {
            if (!page) {
                page = 1
            }

            this.$axios.get(`products?page=${page}&lang_id=${langId}`
            ).then((res) => {
                this.products = res.data.data;
                this.pageParams = res.data.meta
            }).catch(error => {
                if (error) {
                    console.log(error)
                }
            });
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.getData(val)
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
            this.getData(this.currentPage, langId);
        },
        edit(item) {
            this.showEditModal = true;
            this.selectedProduct = item;
        },
        closeProductEditModal() {
            this.showEditModal = false;
            this.selectedProductId = null;
        }
    }
}
</script>

<style scoped>

</style>
