<template>
    <el-dialog
        visible
        title="Update Product"
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
                        <el-input v-model="data.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Product price" prop="desc">
                        <el-input v-model="data.price"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="10" :offset="2">
                    <el-form-item label="Product stock">
                        <el-input type="number" min="0" v-model="data.stock"></el-input>
                    </el-form-item>
                    <el-form-item label="Product currency">
                        <el-select v-model="data.currency" placeholder="Select currency">
                            <el-option label="AMD" value="AMD"/>
                            <el-option label="USD" value="USD"/>
                            <el-option label="RUB" value="RUB"/>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <template slot="footer">
            <el-button type="primary" @click="edit">Submit</el-button>
        </template>
    </el-dialog>
</template>

<script>


import {
    Button as ElButton, Col as ElCol,
    Dialog as ElDialog,
    Option as ElOption, Select as ElSelect,
    Form as ElForm,
    FormItem as ElFormItem,
    Input as ElInput, Row as ElRow
} from "element-ui";

export default {
    name: "product-edit-modal",
    components: {
        ElDialog,
        ElSelect,
        ElOption,
        ElInput,
        ElForm,
        ElFormItem,
        ElButton,
        ElRow,
        ElCol
    },
    props: ['item'],
    data() {
        return {
            data: {
                lang_id: '',
                name: '',
                price: '',
                stock: '',
                currency: '',
            },
            errors: null,
            success: null
        }
    },
    mounted() {
        this.getData(this.item)
    },
    methods: {
        close() {
            this.$emit('close')
        },
        getData(item) {
            this.data.lang_id = item.lang_id
            this.data.name = item.name
            this.data.price = item.price
            this.data.stock = item.stock
            this.data.currency = item.currency
        },
        edit() {
            this.$axios.put(`products/${this.item.id}`, this.data)
                .then((res) => {
                    if (res.data.success) {
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

<style scoped>

</style>
