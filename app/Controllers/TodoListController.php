<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TodoListModel;

class TodoListController extends BaseController
{
    use ResponseTrait;
    
    protected TodoListModel $todoListModel;

    public function __construct(){
        $this->todoListModel = new TodoListModel();
    }

    public function view(){
        return view('todo');
    }

    public function index(){
        // Find the data from database.
        $todoList = $this->todoListModel->findAll();
        return $this->respond([
            "msg"  => "success",
            "data" => $todoList
        ]);
    }

    public function show(?int $key = null){
        if($key === null){
            return $this->failNotFound("Enter the todo key.");
        }
        //Find the data from database
        $todo = $this->todoListModel->find($key);

        if($todo === null){
            return $this->failNotFound("Todo is not found.");
        }

        return $this->respond([
            "msg" => "success",
            "data" => $todo
        ]);
    }

    public function create(){
        //get data from request
        $data = $this->request->getJSON();
        $title = $data->title ?? null;
        $content = $data->content ?? null;

        //check if account & password is correct
        if($title === null || $content === null){
            return $this->fail("Pass in data is not found.", 404);
        }
        if($title === " " || $content === " "){
            return $this->fail("Pass in data is not found.", 404);
        }

        //insert data into DB
        $createdKey = $this->todoListModel->insert([
            "t_title" => $title,
            "t_content" => $content,
            "created" => date("Y-m-d H:i:s"),
            "updated" => date("Y-m-d H:i:s")
        ]);

        //check if insert successfully
        if($createdKey === false){
            return $this->fail("create failed.");
        }
        else{
            return $this->respond([
                "msg" => "create successfully",
                "data" => $createdKey
            ]);
        }
    }
    
    public function update(?int $key = null){
        //get data from request
        $data = $this->request->getJSON();
        $title = $data->title ?? null;
        $content = $data->content ?? null;

        if($key === null){
            return $this->failNotFound("Key is not found.");
        }

        //get new data
        $updateData = $this->todoListModel->find($key);
        if($updateData === null){
            return $this->failNotFound("This data is not found.");
        }
        if($title !== null){
            $updateData["t_title"] = $title;
        }
        if($content !== null){
            $updateData["t_content"] = $content;
        }

        //update
        $isUpdated = $this->todoListModel->update($key, $updateData);
        if($isUpdated === false){
            return $this->fail("update failed.");
        }
        else{
            return $this->respond([
                "msg" => "update successfully"
            ]);
        }
    }

    public function delete(?int $key = null){
        if($key === null){
            return $this->failNotFound("Key is not found.");
        }

        //check if data is exist
        if($this->todoListModel->find($key) === null){
            return $this->failNotFound("This data is not found.");
        }

        //delete
        $isDeleted = $this->todoListModel->delete($key);
        if($isDeleted === false){
            return $this->fail("delete failed.");
        }
        else{
            return $this->respond([
                "msg" => "delete successfully"
            ]);
        }
    }
}
