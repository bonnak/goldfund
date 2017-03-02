<template>
<div class="tb">
  <div class="tb-wrapper">
    <div class="block header">
      <div>
        <el-button
          @click="postCreateMessage">Create New</el-button>
        <el-button
          @click="postDisableSelectedMessage(selected_records)"
          :disabled="!selected_records.length">Disable</el-button>
        <el-button
        @click="postDeleteSelectedMessage(selected_records)"
        :disabled="!selected_records.length">Delete</el-button>
      </div>
    </div>
    <el-table
      border
      :data="dataTable"
      selection-mode="multiple"
      style="width: 100%"
       @selection-change="handleSelectionChange">
      <el-table-column
        type="selection"
        width="50">
      </el-table-column>

      <slot></slot>

      <el-table-column class-name="col-action"
        :context="_self"
        inline-template
        label="Action"
        :fixed="isFixedAction ? 'right' : false"
        min-width="170">
        <div class="btn-tb-action">
          <el-tooltip class="item" effect="dark" content="Edit" placement="top-start">
            <el-button
              size="small"
              type="info"
              @click="handleEdit($index, row)">
              <i class="fa fa-pencil"></i>
            </el-button>
          </el-tooltip>
          <el-tooltip class="item" effect="dark" :content="row.IsActive ? 'Disable' : 'Enable'" placement="top-start">
            <el-button
              size="small"
              type="warning"
              @click="handleDisable($index, row)">
              <i :class="row.IsActive ? 'fa fa-lock' : 'fa fa-unlock'"></i>
            </el-button>
          </el-tooltip>
          <el-tooltip class="item" effect="dark" content="Delete" placement="top-start">
            <el-button
              size="small"
              type="danger"
              @click="handleDelete($index, row)">
              <i class="fa fa-eraser"></i>
            </el-button>
          </el-tooltip>
        </div>
      </el-table-column>
    </el-table>
    <div class="block footer">
      <div>
        <el-button
          @click="postCreateMessage">Create New</el-button>
        <el-button
          @click="postDisableSelectedMessage(selected_records)"
          :disabled="!selected_records.length">Disable</el-button>
        <el-button
          @click="postDeleteSelectedMessage(selected_records)"
          :disabled="!selected_records.length">Delete</el-button>
      </div>
      <el-pagination
        :layout="pagination.last_page > 1 ? 'total, sizes, prev, pager, next, slot' : 'total, sizes, slot'"
        :current-page="pagination.current_page"
        :total="pagination.total"
        :page-count="pagination.last_page"
        :page-size="pagination.per_page"
        :page-sizes="[5, 10, 20, 40, 70, 100]"
        @current-change="handleCurrentPageChange"
        @size-change="handlePageSizeChange"
        :class="{ 'nomargin' : pagination.last_page <= 1 }">
      </el-pagination>
    </div>
  </div>
  <div class="overlay" v-if="dataTable.length == 0">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
</div>
</template>

<script>
export default	{
  name: 'TableGrid',

  props: {
    dataTable: Array,
    filterKey: String,
    pagination: { type: Object, default: {} },
    isFixedAction: { type: Boolean, default: false}
  },

  data(){
    return {
      selected_records : [],
      is_pagable: true
    }
  },

  filters: {
    hideColumn(value, key) {
      return value + key;
    }
  },

  methods: {
    postCreateMessage(){
      this.$emit('post-create-message');
    },

    postEditMessage(record){      
      this.$emit('post-edit-message', record);
    },

    postDeleteMessage(record){  
      this.$emit('post-delete-message', record);
    },

    postDeleteSelectedMessage(data_array){
      this.$emit('post-delete-selected-message', data_array);
    },

    postDisableSelectedMessage(data_array){          
      this.$emit('post-disable-selected-message', data_array);   
    },

    handleDisable(index, row){
      this.$emit('post-disable-message', row);
    },

    handleEdit(index, row){
      this.postEditMessage(row);
    },

    handleDelete(index, row){
      this.$confirm('Are you sure want to delete?', 'Warning', {
        showCancelButton: false,
        type: 'warning'
      }).then(() => {
        this.postDeleteMessage(row);
      });
    },

    handleSelectionChange(data_array){
      this.selected_records = data_array;
    },

    handleCurrentPageChange(val){
      this.$emit('post-current-page-change-message', { current_page: val, per_page: this.pagination.per_page });
    },

    handlePageSizeChange(val) {
      this.$emit('post-page-size-change-message', { current_page: this.pagination.current_page, per_page: val });
    },

    getColumnProperty(col, data){
      console.log(data);

      if(typeof col.name == 'object')      {
        console.log('yeah Object');
      }

      return typeof col.name == 'object' ? col.name + '.Name' : col.name
    }
  },

  watch: {
    pagination(val){      
      this.is_pagable = val == null ? false : true;
    },
    dataTable(val, next){
    }
  }
}
</script>

<style lang="sass" scoped>
.td-action{
  display: flex;
  flex-flow: row nowrap;
}

.btn-tb-action{
	display: flex;
	align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;  
  margin-right: 3px;

  .el-tooltip{
    margin-left: 3px;

    &:first-child{
      margin-left: 5px;
    }
  }
}

.btn-tb-action .fa, 
.btn-tb-action .glyphicon{
	margin-right: 0;
}

.el-pager li a{
  padding: 0 4px;
}

.el-pager li.active a{
  color: #fff;
}

.el-button+.el-button {
  margin-left: 3px;
}

.el-checkbox__inner::after{
  left: 6px;
  top: 3px;
}

.header{
  display: flex;
  flex-flow: row nowrap;
  margin-bottom: 10px;
}

.footer{
  display: flex;
  flex-flow: row nowrap;
  margin-top: 10px;

  .el-pagination{
    flex: 1;
    text-align: right;
    padding: 0;

    &.nomargin .el-pagination__sizes{
      margin-right: 0;
    }
  }
}

.el-button.is-disabled, 
.el-button.is-disabled:focus, 
.el-button.is-disabled:hover{
  // color: #fff;
  // background-color: #e07777;
  // border-color: #e07777;
}

.el-button--info,
.el-button--danger,
.el-button--warning{
  width: 33px;
}

.el-button--info {
  color: #fff;
  background-color: #20a0ff;
  border-color: #20a0ff;
}

.el-button--danger {
  color: #fff;
  background-color: #ff4949;
  border-color: #ff4949;
}

.el-button--warning {
    color: #fff;
    background-color: #f7ba2a;
    border-color: #f7ba2a;
}

.tb{
  position: relative;

  .overlay{
    position: absolute;
    top: 0;
    left: 0;
    min-width: 100%;
    min-height: 100%;
  }
}

.col-action{
  display: flex; 
  align-items: center; 
  justify-content: center;
}

.btn-tb-action{
  display: flex;
  width: 100%;
  justify-content: flex-start;
}    
</style>