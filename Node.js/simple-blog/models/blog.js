const mongoose = require('mongoose');     // mongodb atlas
const Schema = mongoose.Schema;         // structure of schema

const blogSchema = new Schema({           // schema
  title: {
    type: String,
    required: true,
  },
  snippet: {
    type: String,
    required: true,
  },
  body: {
    type: String,
    required: true
  },
}, { timestamps: true });    // options

const Blog = mongoose.model('Blog', blogSchema);      // Blog -> Blogs    // model
module.exports = Blog; 