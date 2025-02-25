<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Business</title>
</head>
<body>
    <h3>Claim Business</h3>
    <form id="claimForm">
        <input type="email" id="claimEmail" placeholder="Enter your email">
        <button type="submit">Claim</button>
    </form>
    <div id="claimMessage"></div>

    <script>
        document.getElementById('claimForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const claimEmail = document.getElementById('claimEmail').value;
            const domain = "{{ $domain }}";
            const emailDomain = claimEmail.split('@')[1];

            if (emailDomain === domain) {
                // Simulate sending a verification email
                document.getElementById('claimMessage').textContent = 'Verification email sent. Please check your inbox.';
                // In a real implementation, you would send an email to the provided address
                // with a link to verify the claim.
            } else {
                document.getElementById('claimMessage').textContent = 'Email domain does not match the website domain.';
            }
        });
    </script>
</body>
</html>
