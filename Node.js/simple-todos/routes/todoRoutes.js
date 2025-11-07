const express = require('express');
const router = express.Router();
const todoController = require('../controllers/todoController');

router.get('/', todoController.getAllTodos);      // GET all todos
router.get('/create', todoController.getCreateTodo);
router.post('/', todoController.createTodo);
router.post('/completed', todoController.deleteCompletedTodos);     // delete
router.get('/:id', todoController.getTodo);
router.get('/:id/edit', todoController.getEditTodo);
router.post('/:id', todoController.updateTodo);    // put
router.post('/:id/delete', todoController.deleteTodo);  // delete    // /delete
router.post('/:id/toggle', todoController.toggleTodo);         // patch

module.exports = router;

// Rule: Always put specific paths (like /create, /completed) before parameterized paths (like /:id).