<template>
    <div>
        <div class="row g-5 g-xl-8">
            <div class="col-xl-2">
                <el-button type="primary" plain @click="openOrderCreateModal">Create order</el-button>
            </div>
            <div class="col-xl-8">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body pt-0">
                        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div v-if="orders" class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 no-footer"
                                       id="kt_table_users">
                                    <thead>
                                        <tr class="text-start text-muted fw-bolder fs-7 gs-0 text-center">
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Weight</th>
                                            <th>Description</th>
                                            <th>Total Price</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-bold">
                                        <tr v-for="order in orders.data">
                                            <td class="text-center">
                                                <span class="align-items-center">{{ order.id}}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ order.product_name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ order.weight }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ order.description }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ order.total_price }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center">{{ order.created_at }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="align-items-center" @click="edit(order.id)">Edit</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <el-pagination
                                    @current-change="handleCurrentChange"
                                    :page-size="orders.per_page"
                                    :current-page="orders.current_page"
                                    layout="prev, pager, next"
                                    :total="orders.total">
                                </el-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <order-create-modal
            v-if="showModal"
            @close="closeOrderCreateModal"
        />

        <order-edit-modal
            v-if="showEditModal"
            @close="closeOrderEditModal"
            :item-id="selectedOrderId"
        />
    </div>
</template>

<script>
import {
    Pagination as ElPagination,
    Button as ElButton,
} from 'element-ui'
import OrderEditModal from "./modals/orderEditModal";
import OrderCreateModal from "./modals/orderCreateModal";

export default {
    name: "dashboard",
    components: {
        OrderCreateModal,
        OrderEditModal,
        ElPagination,
        ElButton
    },
    data() {
        return {
            showModal: false,
            showEditModal: false,
            visible: false,
            orders: null,
            selectedOrderId: null,
            currentPage: null
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        openOrderCreateModal() {
            this.showModal = true;
        },
        closeOrderCreateModal() {
            this.showModal = false;
        },
        closeOrderEditModal() {
            this.showEditModal = false;
            this.selectedOrderId = null;
        },
        getData(page = null) {
            if (!page) {
                page = 1
            }
            this.$axios.get(`orders?page=${page}`
            ).then((res) => {
                this.orders = res.data.orders
            }).catch(error => {
                if (error) {
                    console.log(error)
                }
            });
        },
        edit(itemId) {
            this.showEditModal = true;
            this.selectedOrderId = itemId;
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.getData(val)
        }
    }
}
</script>

<style scoped>

</style>
