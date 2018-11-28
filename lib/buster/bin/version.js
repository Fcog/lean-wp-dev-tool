const fs = require('fs');
const process = require('process');
const location = './.deploy.json';

let deploy = {
  // Make sure the date is in seconds instead of miliseconds as PHP has seconds for time() function.
  version: Math.round( Date.now() / 1000 )
};
write(deploy, done );

function write( file, done ) {
  let json = '';
  try {
    json = JSON.stringify(file);
  } catch ( e ) {
    json = '{}';
    console.log( 'There was an error while the file was updated.' );
  }
  fs.writeFile( location, json, 'utf8', done);
}

function done( error ) {
  if ( error ) {
    console.log( 'There was an error creating the file', error );
    process.exit(1);
  } else {
    console.log( `New version: ${deploy.version} created.` );
    process.exit(0);
  }
}
