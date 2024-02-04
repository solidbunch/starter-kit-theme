/**
 * Render schema org for FAQ section in Gutenberg editor
 *
 * @param {Object} props
 */
const schemaOrgEditorGenerator = (props) => {

  const questions = props.data.map(faq => {
    return {
      '@type':'Question',
      'name': faq.question,
      'acceptedAnswer':
        {
          '@type':'Answer',
          'text': faq.answer
        }
    };
  });

  const schema = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    'mainEntity': questions
  };

  return (
    <script type="application/ld+json">
      {JSON.stringify(schema)}
    </script>
  );
};

export default schemaOrgEditorGenerator;
