import * as THREE from "three";
import GUI from "lil-gui";
import vertexShader from "./shaders/vertexShader.glsl?raw";
import fragmentShader from "./shaders/fragmentShader.glsl?raw";

const SILK_CANVAS_SELECTOR = "#theme-silk-canvas";

function getSilkWaveColor() {
  const rootStyle = window.getComputedStyle(document.documentElement);
  const cssVar = rootStyle.getPropertyValue("--theme-silk-wave").trim();
  return cssVar || "#ffffff";
}

function initSilkBackground() {
  const canvas =
    document.querySelector<HTMLCanvasElement>(SILK_CANVAS_SELECTOR);
  if (!canvas) {
    return;
  }

  const scene = new THREE.Scene();
  const gui = new GUI({ width: 300 });
  // デバッグツールバーを表示・非表示にする
  gui.show(false);

  const sizes = {
    width: window.innerWidth,
    height: window.innerHeight,
  };

  const camera = new THREE.PerspectiveCamera(
    75,
    sizes.width / sizes.height,
    0.1,
    100,
  );
  camera.position.set(0, 0, 0.5);
  scene.add(camera);

  const renderer = new THREE.WebGLRenderer({
    canvas,
    antialias: true,
    alpha: true,
  });

  renderer.setClearColor(0x000000, 0);
  renderer.setSize(sizes.width, sizes.height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

  const geometry = new THREE.PlaneGeometry(2, 2, 256, 256);
  const params = {
    amplitude: 0.2,
    detailAmplitude: 0.02,
    ampDecay: 0.892,
    noiseStrength: 0.0,
    speed: 3.0,
    lightX: -0.015,
    lightY: 0.007,
    lightZ: 0.0,
    specularStrength: 0.011,
    specularPower: 1,
    specularSecondaryStrength: 0.047,
    specularSecondaryPower: 1,
    fresnelStrength: 0.005,
    fresnelPower: 0.5,
  };

  const material = new THREE.ShaderMaterial({
    vertexShader,
    fragmentShader,
    transparent: true,
    side: THREE.DoubleSide,
    uniforms: {
      uFrequency: { value: new THREE.Vector2(10, 20) },
      uTime: { value: 0 },
      uColor: { value: new THREE.Color(getSilkWaveColor()) },
      uAmplitude: { value: params.amplitude },
      uDetailAmplitude: { value: params.detailAmplitude },
      uAmpDecay: { value: params.ampDecay },
      uNoiseStrength: { value: params.noiseStrength },
      uSpeed: { value: params.speed },
      uLightDirection: {
        value: new THREE.Vector3(
          params.lightX,
          params.lightY,
          params.lightZ,
        ).normalize(),
      },
      uSpecularStrength: { value: params.specularStrength },
      uSpecularPower: { value: params.specularPower },
      uSpecularSecondaryStrength: { value: params.specularSecondaryStrength },
      uSpecularSecondaryPower: { value: params.specularSecondaryPower },
      uFresnelStrength: { value: params.fresnelStrength },
      uFresnelPower: { value: params.fresnelPower },
    },
  });

  const mesh = new THREE.Mesh(geometry, material);
  scene.add(mesh);

  const updateLightDirection = () => {
    material.uniforms.uLightDirection.value
      .set(params.lightX, params.lightY, params.lightZ)
      .normalize();
  };

  const waveFolder = gui.addFolder("波形");
  waveFolder
    .add(material.uniforms.uFrequency.value, "x")
    .min(0)
    .max(20)
    .step(0.001)
    .name("周波数 X");
  waveFolder
    .add(material.uniforms.uFrequency.value, "y")
    .min(0)
    .max(20)
    .step(0.001)
    .name("周波数 Y");
  waveFolder
    .add(params, "amplitude")
    .min(0)
    .max(0.2)
    .step(0.001)
    .name("振幅")
    .onChange((value: number) => {
      material.uniforms.uAmplitude.value = value;
    });
  waveFolder
    .add(params, "detailAmplitude")
    .min(0)
    .max(0.1)
    .step(0.001)
    .name("細部振幅")
    .onChange((value: number) => {
      material.uniforms.uDetailAmplitude.value = value;
    });
  waveFolder
    .add(params, "ampDecay")
    .min(0)
    .max(1)
    .step(0.001)
    .name("減衰")
    .onChange((value: number) => {
      material.uniforms.uAmpDecay.value = value;
    });
  waveFolder
    .add(params, "noiseStrength")
    .min(0)
    .max(0.5)
    .step(0.001)
    .name("ノイズ")
    .onChange((value: number) => {
      material.uniforms.uNoiseStrength.value = value;
    });
  waveFolder
    .add(params, "speed")
    .min(0)
    .max(3)
    .step(0.001)
    .name("速度")
    .onChange((value: number) => {
      material.uniforms.uSpeed.value = value;
    });

  const reflectionFolder = gui.addFolder("光の反射");
  reflectionFolder
    .add(params, "lightX")
    .min(-2)
    .max(2)
    .step(0.001)
    .name("光の方向 X")
    .onChange(updateLightDirection);
  reflectionFolder
    .add(params, "lightY")
    .min(-2)
    .max(2)
    .step(0.001)
    .name("光の方向 Y")
    .onChange(updateLightDirection);
  reflectionFolder
    .add(params, "lightZ")
    .min(-2)
    .max(2)
    .step(0.001)
    .name("光の方向 Z")
    .onChange(updateLightDirection);
  reflectionFolder
    .add(params, "specularStrength")
    .min(0)
    .max(2)
    .step(0.001)
    .name("反射の強さ（主）")
    .onChange((value: number) => {
      material.uniforms.uSpecularStrength.value = value;
    });
  reflectionFolder
    .add(params, "specularPower")
    .min(1)
    .max(200)
    .step(1)
    .name("反射の鋭さ（主）")
    .onChange((value: number) => {
      material.uniforms.uSpecularPower.value = value;
    });
  reflectionFolder
    .add(params, "specularSecondaryStrength")
    .min(0)
    .max(2)
    .step(0.001)
    .name("反射の強さ（副）")
    .onChange((value: number) => {
      material.uniforms.uSpecularSecondaryStrength.value = value;
    });
  reflectionFolder
    .add(params, "specularSecondaryPower")
    .min(1)
    .max(200)
    .step(1)
    .name("反射の鋭さ（副）")
    .onChange((value: number) => {
      material.uniforms.uSpecularSecondaryPower.value = value;
    });
  reflectionFolder
    .add(params, "fresnelStrength")
    .min(0)
    .max(1)
    .step(0.001)
    .name("縁の光の強さ")
    .onChange((value: number) => {
      material.uniforms.uFresnelStrength.value = value;
    });
  reflectionFolder
    .add(params, "fresnelPower")
    .min(0.5)
    .max(8)
    .step(0.001)
    .name("縁の光の広がり")
    .onChange((value: number) => {
      material.uniforms.uFresnelPower.value = value;
    });
  reflectionFolder.open();
  waveFolder.open();

  const clock = new THREE.Clock();
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
  let frameId = 0;
  let destroyed = false;

  const renderFrame = () => {
    if (destroyed) {
      return;
    }
    if (!reduceMotion.matches) {
      material.uniforms.uTime.value = clock.getElapsedTime();
      frameId = window.requestAnimationFrame(renderFrame);
    }
    renderer.render(scene, camera);
  };

  const handleResize = () => {
    sizes.width = window.innerWidth;
    sizes.height = window.innerHeight;

    renderer.setSize(sizes.width, sizes.height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    camera.aspect = sizes.width / sizes.height;
    camera.updateProjectionMatrix();
    renderer.render(scene, camera);
  };

  renderFrame();
  window.addEventListener("resize", handleResize);

  return () => {
    destroyed = true;
    if (frameId) {
      window.cancelAnimationFrame(frameId);
    }
    window.removeEventListener("resize", handleResize);
    gui.destroy();
    geometry.dispose();
    material.dispose();
    renderer.dispose();
  };
}

document.addEventListener("DOMContentLoaded", () => {
  initSilkBackground();
});
