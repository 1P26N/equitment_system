<?php
/*  在此处定义所有服务器相关的环境变量 */

//登陆数据库相关的变量
    $USER_DATABASE_HOST="localhost";
    $USER_DATABASE_USER="root";
    $USER_DATABASE_PWD="GMMC123456";
    $USER_DATABASE_DB="login";

//工具数据库相关变量
    //数据库名称
    $TOOLS_DATABASE_DB="equipment";
    //在用工具表名
    $TOOLS_DATABASE_TABLE="tools";
    //工具库存表名
    $TOOLS_DATABASE_STOCK_TABLE="tools_stock";
    //事件记录数据库
    $EVENT_DATABASE_TABLE="event";
    
    
//工具备件下拉列表数据
    
    //品牌
    $TOOLS_BRAND=array("伍尔特","金仕霸","东空","英格索兰","瓜生","博世","松下");
    
    //类型
    $TOOLS_TYPE=array("气动","电动定扭","电动冲击","气动定扭","气动冲击");
    
    //班组
    $TOOLS_GROUP=array("内装一班","内装二班","内装三班","发动机一班","发动机二班","悬挂一班","整车一班","整车二班","检验班","保全班","技术系","仓库");
    
    //状态
    $TOOLS_STATE=array("在库","备用","领用","报废","待修");
    
//事件记录对应下拉列表数据
    
    //类别  “系统”选型自动生成，不可选
    $EVENT_TYPE=array("入库","出库","修改","维修","保养");
    
?>