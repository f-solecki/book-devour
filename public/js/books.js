document.addEventListener("DOMContentLoaded", function (event) {
  const loanButtons = document.querySelectorAll(".loan-book");
  const returnButtons = document.querySelectorAll(".return-book");
  const deleteButtons = document.querySelectorAll(".delete-btn");

  loanButtons.forEach((button) => {
    button.addEventListener("click", function () {
      loanBook(this.dataset.bookId);
    });
  });

  returnButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookId = this.dataset.bookId;
      returnBook(bookId);
    });
  });

  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookId = this.dataset.bookId;
      window.confirm("Are you sure you want to delete this book?") &&
        deleteBook(bookId);
    });
  });
});

function deleteBook(bookId) {
  fetch("/delete_book", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      book_id: bookId,
    }),
  }).then((response) => {
    if (response.ok) {
      console.log("Book deleted successfully");
      location.reload(); // Reload the page to reflect changes
    } else {
      alert("Error deleting the book. Please try again.");
    }
  });
}

function loanBook(bookId) {
  fetch("/loan_book", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      book_id: bookId,
    }),
  }).then((response) => {
    if (response.ok) {
      console.log("Book loaned successfully");
      location.reload(); // Reload the page to reflect changes
    } else {
      alert("Error loaning the book. Please try again.");
    }
  });
}

function returnBook(bookId) {
  fetch("/return_book", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      book_id: bookId,
    }),
  }).then((response) => {
    if (response.ok) {
      console.log("Book returned successfully");
      location.reload(); // Reload the page to reflect changes
    } else {
      alert("Error returning the book. Please try again.");
    }
  });
}
