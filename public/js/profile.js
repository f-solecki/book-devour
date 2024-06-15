document.addEventListener("DOMContentLoaded", function (event) {
  const removeButton = document.querySelectorAll(".remove-account");

  removeButton[0].addEventListener("click", function () {
    if (
      !window.confirm(
        "Are you sure you want to remove your account? This action is irreversible."
      )
    ) {
      return;
    }

    removeAccount();
  });
});

function removeAccount() {
  fetch("/remove_account", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
  }).then((response) => {
    if (response.ok) {
      console.log("Account removed successfully");
      location.reload();
    } else {
      alert("Error removing the account. Please try again.");
    }
  });
}
