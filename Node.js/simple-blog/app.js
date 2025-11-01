const express = require('express');
const morgan = require('morgan');
const mongoose = require('mongoose');
const blogRoutes = require('./routes/blogRoutes');

// express app
const app = express();    // instance

// connect to mongodb
const dbURI = ''    // connect link

mongoose.connect(dbURI)    // async
  .then(result => app.listen(yourPortnumber))    // success     // port number
  .catch(err => console.log(err));

// register view engine
app.set('view engine', 'ejs');        // configure app settings

// middleware & static files
app.use(express.static('public'));     // static files will be available in public folder
app.use(express.urlencoded({ extended: true }));        // take data from form url and encode it to readable data 
app.use(morgan('dev'));     // format
app.use((req, res, next) => {
  res.locals.path = req.path;
  next();
});

// routes
app.get('/', (req, res) => {
  res.redirect('/blogs');
});

app.get('/about', (req, res) => {
  res.render('about', { title: 'About' });
});

// blog routes
app.use('/blogs', blogRoutes);    // activate router when go to /blogs

// 404 page
app.use((req, res) => {
  res.status(404).render('404', { title: '404' });
});
