<template>
    <el-dialog
        visible
        title="Add New Product Name"
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
                    <el-form-item label="Select Language">
                        <select class="form-control" v-model="langId">
                            <option value="">select languages</option>
                            <option v-for="item in languages" :value="item.id">{{ item.context }}</option>
                        </select>
                    </el-form-item>
                </el-col>
                <el-col :span="10" :offset="2">
                    <el-form-item label="Product Name">
                        <el-input v-model="name"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <template slot="footer">
            <el-button type="primary" @click="add()">Submit</el-button>
        </template>
    </el-dialog>
</template>

<script>
import {
    Button as ElButton, Col as ElCol,
    Dialog as ElDialog, Form as ElForm, FormItem as ElFormItem,
    Input as ElInput,
    Option as ElOption, Row as ElRow,
    Select as ElSelect
} from "element-ui";

export default {
    name: "add-new-product-name",
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
    data() {
        return {
            langId: '',
            name: '',
            errors: null,
            success: null
        }
    },
    props: ['id', 'languages'],
    methods: {
        close() {
            this.$emit('close')
        },
        add() {
            this.$axios.post(`add-prod-name`,
                {
                    product_id: this.id,
                    lang_id: this.langId,
                    name: this.name
                })
                .then((res) => {
                    if (res.data.success) {
                        this.success = res.data.message
                        setTimeout(() => location.reload(), 1500)
                    }
                })
                .catch(error => {
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
