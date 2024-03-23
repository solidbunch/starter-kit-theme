// letter protection
export const handleKeyPress = (event) => {
  const allowedCharacters = /[0-9]/;
  if (!allowedCharacters.test(event.key)) {
    event.preventDefault();
  }
};
