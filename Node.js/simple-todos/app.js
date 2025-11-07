const express = require('express');
const mongoose = require('mongoose');
const todoRoutes = require('./routes/todoRoutes');

const app = express();

// connect to mongodb
const dbURI = 'mongodb+srv://adel:amroadel123.@cluster0.dmzt7aq.mongodb.net/?appName=Cluster0'

mongoose.connect(dbURI)    // async
  .then(result => app.listen(3000))    // success    
  .catch(err => console.log(err));

// register view engine
app.set('view engine', 'ejs');          

// middleware & static files
app.use(express.static('public'));     
app.use(express.urlencoded({ extended: true }));        
app.use((req, res, next) => {
  res.locals.path = req.path;
  next();
});

// routes
app.get('/', (req, res) => {
  res.redirect('/todos');
});

// todo routes
app.use('/todos', todoRoutes);    // activate router when go to /todos

// 404 page
app.use((req, res) => {
  res.status(404).render('404', { title: '404' });
});



/*
<!-- 
            <%- include('form', { 
                todo: {}, 
                method: 'POST', 
                action: '/todos', 
                buttonText: 'Create Todo' 
            }) %>
-->
*/