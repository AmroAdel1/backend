const express = require('express');
const morgan = require('morgan');
const mongoose = require('mongoose');
const blogRoutes = require('./routes/blogRoutes');

// express app
const app = express();    // instance

// connect to mongodb
const dbURI = 'mongodb+srv://adel:amroadel123.@cluster0.dmzt7aq.mongodb.net/?appName=Cluster0'

mongoose.connect(dbURI)    // async
  .then(result => app.listen(3000))    // success    
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

/*
const Blog = require('./models/blog');

// app.set('views', 'myviews');       // change default views folder

// listen for requests
app.listen(3000);

app.use((req, res, next) => {
  console.log('new request made:');
  console.log('host: ', req.hostname);
  console.log('path: ', req.path);
  console.log('method: ', req.method);
  next();     // need to stop middleware
});

app.use((req, res, next) => {
  console.log('in the next middleware');
  next();
});

app.get('/', (req, res) => {
  // res.send('<p>home page</p>');
  // res.sendFile('./views/index.html', { root: __dirname });    // like res.write and res.end, no need header   // default absolute path
  const blogs = [
    {title: 'Yoshi finds eggs', snippet: 'Lorem ipsum dolor sit amet consectetur'},
    {title: 'Mario finds stars', snippet: 'Lorem ipsum dolor sit amet consectetur'},
    {title: 'How to defeat bowser', snippet: 'Lorem ipsum dolor sit amet consectetur'},
  ];
  res.render('index', { title: 'Home', blogs });      // sending data to view    // blogs: blogs
});

app.get('/about', (req, res) => {
  // res.send('<p>about page</p>');
  //res.sendFile('./views/about.html', { root: __dirname });
  res.render('about', { title: 'About' });
});

app.get('/blogs/create', (req, res) => {
  res.render('create', { title: 'Create a new blog' });
});

// 404 page
app.use((req, res) => {       // middleware   // order matters  // can type any url
  //res.status(404).sendFile('./views/404.html', { root: __dirname });
  res.status(404).render('404', { title: '404' });
});
*/

/*
// redirects
app.get('/about-us', (req, res) => {
  res.redirect('/about');
});
*/

/*
// mongoose & mongo tests
app.get('/add-blog', (req, res) => {      // go to localhost:3000/add-blog to add query in db
  const blog = new Blog({
    title: 'new blog',
    snippet: 'about my new blog',
    body: 'more about my new blog'
  })

  blog.save()       // save to db       // async   // takes time
    .then(result => {
      res.send(result);
    })
    .catch(err => {
      console.log(err);
    });
});

app.get('/all-blogs', (req, res) => {
  Blog.find()
    .then(result => {
      res.send(result);
    })
    .catch(err => {
      console.log(err);
    });
});

app.get('/single-blog', (req, res) => {
  Blog.findById('6904fa1a84a6e0161b83870f')
    .then(result => {
      res.send(result);
    })
    .catch(err => {
      console.log(err);
    });
});
*/

// filter blogs by category, add author