const Todo = require('../models/todo');

// Get all todos
const getAllTodos = (req, res) => {
  const { completed, priority } = req.query;
  Todo.find(req.query).sort({ createdAt: -1 })
    .then(todos => 
      res.render('todos/index', { 
      todos,
      filters: { completed, priority }, 
      title: 'All Todos'  }))   
    .catch(err => console.log(err) || res.redirect('/todos'));    // /
};

// Get a single todo
const getTodo = (req, res) => {
  Todo.findById(req.params.id)
    .then(todo => todo ? res.render('todos/show', { todo }) : res.redirect('/todos'))     // { blog: result, title: 'Todo Details' }
    .catch(err => console.log(err) || res.redirect('/todos'));
};

// Show create form
const getCreateTodo = (req, res) => {
  res.render('todos/create', { title: 'Create New Todo' });
};

// Create a new todo
/*
const createTodo = (req, res) => {
  new Todo(req.body).save()
    .then(() => res.redirect('/todos'))
    .catch(err => console.log(err) || res.redirect('/todos'));
};
*/

const createTodo = (req, res) => {
  Todo.create(req.body)
    .then(() => res.redirect('/todos'))
    .catch(err => res.status(400).render('todos/create', { 
      error: err.message,
      title: 'Create Todo'
    }));
};

// Get edit form
const getEditTodo = (req, res) => {
  Todo.findById(req.params.id)
    .then(todo => todo ? res.render('todos/edit', { todo }) : res.redirect('/todos'))
    .catch(err => console.log(err) || res.redirect('/todos'));
};

// Update a todo
const updateTodo = (req, res) => {
  console.log('req.body:', req.body);
  console.log('completed value:', req.body.completed);
  console.log('completed type:', typeof req.body.completed);

  const updates = {
    title: req.body.title,
    description: req.body.description,
    priority: req.body.priority,
    completed: Array.isArray(req.body.completed) 
      ? req.body.completed[req.body.completed.length - 1] === 'true'
      : req.body.completed === 'true'
  };
  Todo.findByIdAndUpdate(req.params.id, updates, { new: true })
    .then(() => res.redirect('/todos'))         // render ('todos/update', { todo: result, title: 'Update Todo' )
    .catch(err => console.log(err) || res.redirect('/todos'));
};

// Delete a todo
const deleteTodo = (req, res) => {
  Todo.findByIdAndDelete(req.params.id)
    .then(() => res.redirect('/todos'))
    .catch(err => console.log(err) || res.redirect('/todos'));
};

// Delete all completed todos
const deleteCompletedTodos = (req, res) => {
  Todo.deleteMany({ completed: true })
    .then(() => res.redirect('/todos'))
    .catch(err => console.log(err) || res.redirect('/todos'));
};

// Toggle a todo
const toggleTodo = (req, res) => {
  Todo.findById(req.params.id)
    .then(todo => {
      if (!todo) return res.redirect('/todos');
      todo.completed = !todo.completed;
      return todo.save();
    })
    .then(() => res.redirect('/todos'))
    .catch(err => console.log(err) || res.redirect('/todos'));
};

module.exports = {
  getAllTodos, 
  getTodo, 
  createTodo, 
  getCreateTodo,
  updateTodo,
  getEditTodo,
  deleteTodo,
  deleteCompletedTodos,
  toggleTodo,
}