const assert = require('node:assert/strict');
const { BatchRunner, actionCount, confirmPhrase, contrastText } = require('../assets/core.js');
const initial = { token: 'job-a', type: 'action', processed: 0, total: 2, done: false };

(async () => {
  let calls = 0;
  const normal = new BatchRunner(async (op, payload) => {
    assert.equal(op, 'act'); assert.equal(payload.token, initial.token); calls++;
    return { ...initial, processed: calls, done: calls === 2 };
  }, () => {});
  assert.equal(calls, 0, 'Constructing a runner must not start cleanup');
  const completed = await normal.run('act', initial);
  assert.equal(calls, 2); assert.equal(completed.done, true); assert.equal(normal.running, false);
  await normal.run('act', completed); assert.equal(calls, 2, 'Completed runs must not send another request');

  let release;
  let pauseCalls = 0;
  const pause = new BatchRunner(async () => {
    pauseCalls++;
    if (pauseCalls === 1) return new Promise(resolve => { release = resolve; });
    return { ...initial, processed: 2, done: true };
  }, () => {});
  const first = pause.run('act', initial);
  await assert.rejects(pause.run('act', initial), /already running/);
  pause.pause(); release({ ...initial, processed: 1 });
  const stopped = await first;
  assert.equal(pauseCalls, 1, 'Pause must not start another batch');
  assert.equal(stopped.processed, 1); assert.equal(pause.running, false);
  await pause.run('act', stopped); assert.equal(pauseCalls, 2);

  const mismatch = new BatchRunner(async () => ({ ...initial, token: 'another-job' }), () => assert.fail('Different session must not update progress'));
  await assert.rejects(mismatch.run('act', initial), /different session/);
  assert.equal(mismatch.running, false);
  let failureCalls = 0;
  const failing = new BatchRunner(async () => { failureCalls++; throw new Error('Denied'); }, () => {});
  await assert.rejects(failing.run('act', initial), /Denied/); assert.equal(failureCalls, 1); assert.equal(failing.running, false);
  assert.equal(actionCount('selected', new Set([1, 2]), 500), 2);
  assert.equal(actionCount('all', new Set([1, 2]), 500), 500);
  assert.equal(confirmPhrase(2), 'PERMANENTLY DELETE 2');
  assert.equal(contrastText('#ffffff'), '#171a20'); assert.equal(contrastText('#000000'), '#ffffff');
  console.log('PASS: 15 batching, confirmation-count and contrast checks.');
})().catch(error => { console.error(error); process.exit(1); });
