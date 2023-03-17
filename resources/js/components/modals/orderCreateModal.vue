<template>
    <el-dialog
        visible
        title="Order Create"
        @update:visible="close"
        top="5vh"
    >
        <el-form label-position="top" label-width="100px" ref="form" :inline="true">
            <el-row :span="20">
                <el-row>
                    <el-col :span="22" :offset="1">
                        <div v-for="error in errors" class="alert alert-danger">
                            {{ error[0] }}
                        </div>
                        <div v-if="success" class="alert alert-success">
                            {{ success }}
                        </div>
                    </el-col>
                </el-row>
                <el-col :span="10" :offset="1">
                    <el-form-item label="Product name">
                        <el-input v-model="data.product_name"></el-input>
                    </el-form-item>
                    <el-form-item label="Product weight" prop="desc">
                        <el-input v-model="data.weight"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="10" :offset="2">
                    <el-form-item label="Total price">
                        <el-input v-model="data.total_price"></el-input>
                    </el-form-item>
                    <el-form-item label="Description" prop="desc">
                        <el-input type="textarea" :rows="2" v-model="data.description"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <template slot="footer">
            <el-button type="primary" @click="send">Submit</el-button>
        </template>
    </el-dialog>
</template>

<script>
import {
    Dialog as ElDialog,
    Input as ElInput,
    Form as ElForm,
    FormItem as ElFormItem,
    Button as ElButton,
    Row as ElRow,
    Col as ElCol,
} from 'element-ui'

export default {
    name: "order-create-modal",
    components: {
        ElDialog,
        ElInput,
        ElForm,
        ElFormItem,
        ElButton,
        ElRow,
        ElCol
    },
    data() {
        return {
            data: {
                product_name: '',
                weight: '',
                description: '',
                total_price: '',
            },
            errors: null,
            success: null
        }
    },
    methods: {
        close() {
            this.$emit('close')
        },
        send() {
            this.$axios.post('orders',
                {
                    product_name: this.data.product_name,
                    weight: this.data.weight,
                    description: this.data.description,
                    total_price: this.data.total_price,
                },
                // {
                //     headers:
                //         {
                //             Authorization: 'Bearer ' + window.localStorage.getItem('token')
                //         }
                // }
            ).then((res) => {
                if (res.data.success) {
                    this.errors = null
                    this.success = res.data.message
                    setTimeout(() => location.reload(), 1500)
                }
            }).catch(error => {
                if (error.response) {
                    this.errors = error.response.data.errors
                }
            });
        }

    }
}
</script>

<style lang="scss" scoped>
:deep(.el-dialog__body) {
    overflow: auto;
    //max-height: 550px;
}

.el-form {
    .el-form-item {
        width: 100%;

        :deep(.el-form-item__label) {
            padding: 0;
        }
    }
}

:deep(.el-dialog__footer) {
    margin-right: 20px;
}
</style>
